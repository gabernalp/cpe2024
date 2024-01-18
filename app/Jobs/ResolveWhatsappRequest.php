<?php

namespace App\Jobs;

use App\Models\BackgroundProcess;
use App\Models\DocumentType;
use App\Models\ChallengesUser;
use App\Models\Challenge;
use App\Models\CourseSchedule;
use App\Models\Course;
use App\Models\WhatsappWord;
use App\Models\CoursesUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Positus\Laravel\Client;
use App\Models\User;
use App\Models\TagCategory;
use App\Models\Tag;
use App\Models\ResourcesAudit;
use App\Models\UserChainBlock;
use App\Models\ReferenceType;
use Illuminate\Support\Facades\DB;
use App\Models\EventsSchedule;
use App\Models\ResourcesCategory;
use App\Models\ResourcesSubcategory;
use App\Models\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ResolveWhatsappRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data){
        $this->data = $data;
    }
    
    public $siteUrl = 'https://conectarparaeducar.co';

    public static function setStatus($userid,$status){

        DB::table('user_status')->insert([
            ['user_id' => $userid, 'status' => $status, 'time' => date("Y-m-d H:i:s")],
        ]);

    }

    public static function getStatus($userStatus){

        if(!$userstatusnow = DB::table('user_status')->where('user_id',$userStatus)->latest('id')->first()){

			ResolveWhatsappRequest::setStatus($userStatus,'hola');

			return 'hola';

		}
		else{

			$statusnow = $userstatusnow->status;

        	return $statusnow;

		}


    }
    
    public static function accessResource($resource,$userResource){
        
        $access = new ResourcesAudit;
        $access->ip = request()->ip() ?? null;
        $access->recurso_id = $resource;
        $access->user_id = $userResource;
        $access->save();
        
    }

	public static function userReal($userReal){

		$userRealObj = User::where('id',$userReal)->first();

		if($userRealObj->email_verified_at){

			return true;

		}
		else{

			return false;

		}

	}


    public static function checkUser($phone,$name){

        if(DB::table('users')->where('phone',$phone)->first()){
			DB::update("update users set deleted_at = null where phone = '".$phone."'");

        }
        else{


           	ResolveWhatsappRequest::inituser($phone,$name);

			$iduserph = ResolveWhatsappRequest::idUser($phone);

			ResolveWhatsappRequest::setStatus($iduserph,'hola');

        }

    }

	public static function idUser($phone){

		$idUserObj = User::where('phone',$phone)->first();

		return $idUserObj->id;

    }

    public static function inituser($phone,$name){

        $newUser = new User;
        $newUser->phone = $phone;
        $newUser->name = mb_strtoupper($name);
		$newUser->document = substr($phone,2,10);
		$newUser->password = Hash::make(substr($phone,2,10));
		$newUser->email = $phone."@conectarparaeducar.co";
        $newUser->documenttype_id = 1;
        $newUser->save();
    }


	public static function fixtxt($wordtofix){
        $fixedword = str_replace(' ','%20',$wordtofix);
        $fixedword = str_replace('\n','%0D%0A',$fixedword);
        return $fixedword;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if(array_key_exists('messages',$this->data)){

            $number = Client::number('64184be2-df16-4cfd-bacf-c40804ba64d9');

            $contentType = $this->data['messages'][0]['type'];
            
            $wa_id = $this->data['contacts'][0]['wa_id'];

            $name = $this->data['contacts'][0]['profile']['name'];

            $msgid = $this->data['messages'][0]['id'];

            $refsearch = ReferenceType::where('code',$contentType)->first();

            $refid = $refsearch->id;

			ResolveWhatsappRequest::checkUser($wa_id,$name);

			$idUser = ResolveWhatsappRequest::idUser($wa_id);

			$realUser = ResolveWhatsappRequest::userReal($idUser);

			$sendObj = "SendText";

			$status = ResolveWhatsappRequest::getStatus($idUser);


			@$txtIn = trim(mb_strtolower($this->data['messages'][0]['text']['body']));


			$invalid = strip_tags(ResolveWhatsappRequest::fixtxt('Escribiste o enviaste una respuesta diferente a las opciones disponibles, recuerda que soy un *WhatsApp Automatizado* 🤖 y solo puedo entender lo que me dices si escribes correctamente las opciones que te doy 😉\n\n☝️ *Consejo:* escribe o envia únicamente las palabras, el número indicado o el formato solicitado sin agregar palabras adicionales. \n\nVuelve a leer el menú anterior y escribe *únicamente el número* o la palabra de la opción que quieres explorar.\n\nEscribe la palabra *INICIO* para ir al menú principal.'));

			//Validacion de objeto de entrada
            if ($contentType == 'text') {
                
                $txtIn = trim(mb_strtolower($this->data['messages'][0]['text']['body']));
                if((ResolveWhatsappRequest::getStatus($idUser) == 'Tags') && (!is_numeric($txtIn))){
                    ResolveWhatsappRequest::setStatus($idUser,'hola');
                }
                if((ResolveWhatsappRequest::getStatus($idUser) == 'Download') && (!is_numeric($txtIn))){
                    ResolveWhatsappRequest::setStatus($idUser,'hola');
                }
                if($txtIn == 'uno'){
                        $status = ResolveWhatsappRequest::getStatus($idUser);
                        $courseExplode = explode("|",$status);
                        $courseInsertId = $courseExplode[1];
                        $courseLimit = CourseSchedule::where('id',$courseInsertId)->first();
                        if ($courseLimit->course->unico == 1){
                        //$courseOne = Course::find($courseLimit->course_id);
                            $challengeOne = Challenge::where('course_id',$courseLimit->course_id)->first();
                            $challengeMessage = "Tu reto se titula: *".$challengeOne->name."*\n".$challengeOne->goal."\n\nInstrucciones:\n\n".$challengeOne->action_detail."\n\nRecuerda que en este reto debes *".$challengeOne->challenge_action."* y como es un *reto único*, no debes enviarnos una respuesta.";
                            DB::table('uniques')->insert(['user_id' => $idUser,'challenge_id' => $challengeOne->id,'created_at' => date("Y-m-d H:i:s")]);
                            $message = $number->sendText('+'.$wa_id,$challengeMessage);
                            $attachmentType = ucfirst($challengeOne->referencetype_capsule->code);
                            $sendObject = 'send'.$attachmentType;
                            if($attachmentType == 'Audio'){

                                $filesend = $number->$sendObject('+'.$wa_id,$challengeOne->capsule_file->getUrl());

                            }
                            else{
                                if($attachmentType == 'Image'){

                                    $filesend = $number->sendImage('+'.$wa_id,$challengeOne->capsule_file->getUrl());

                                }
                                else{

                                    $filesend = $number->sendDocument('+'.$wa_id,$challengeOne->capsule_file->getUrl(),"Capsula de conocimiento");

                                }

                            }
                        }
                        else{
                            
                            $message = $number->sendText('+'.$wa_id,'Este ciclo de retos no tiene habilitada la opción de reto unico. Escribe *TEMAS* para conocer la lista de temas disponibles o *INICIO* para ir al menu principal');

                        
                        }

                }
                else{
                    
                                        if(($txtIn == '2') && ($status == 'hola')){
                                            
                                                $tagCategory = TagCategory::find(4)->load('tagCategoryTags');
                                                $tags = $tagCategory->tagCategoryTags;
                                                $mensajes = '';
                                                foreach($tags as $key => $tag){

                                                    $mensaje = "*".$tag->id.".* ".$tag->name."\n";
                                                    $mensajes = $mensajes.$mensaje;
                                                }

                                                $message = $number->sendText("+".$wa_id,"Escribe *el número* de la etiqueta que quieres explorar:\n".$mensajes);
                                                ResolveWhatsappRequest::setStatus($idUser,'Tags');

                                            
                                        }
				else{

					if($txtIn == 'cambiar'){

						if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->get()->count() > 0) {

							$actualCourse = CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->first();
							$countChallengesUser = ChallengesUser:: where('user_id',$idUser)->where('courseschedule_id',$actualCourse->course_schedule_id)->get()->count();
							$challengeToUpdate = ChallengesUser::where('user_id',$idUser)->where('courseschedule_id',$actualCourse->course_schedule_id)->skip(($countChallengesUser-1))->first();
							$challengeToUpdate->status = 'Enviado';
							$challengeToUpdate->save();
							$actualCourse->actual_challenge = $countChallengesUser;
							$actualCourse->save();
							ResolveWhatsappRequest::setStatus($idUser,'hola');
							$message = $number->sendText("+".$wa_id,'Has decido cambiar tu respuesta. Escribe *RESPONDER* cuando estes listo para enviarla nuevamente. Recuerda que si no envias una nueva respuesta, el sistema asumirá la última enviada.');

						}
						else{
							ResolveWhatsappRequest::setStatus($idUser,'hola');
							$message = $number->sendText("+".$wa_id,'No estas inscrito en ningun ciclo de retos actualmente');
						}

					}
					else{

						if(ResolveWhatsappRequest::getStatus($idUser) == 'Tags'){
                            
                            $tags = Tag::find($txtIn)->load('tagsResources');
                            $resources = $tags->tagsResources;
                            $mensajes = '';
                            foreach($resources as $key => $resource){
                                
                                $mensaje = "*".$resource->id.".* ".$resource->name."\n";
                                $mensajes = $mensajes.$mensaje;
                                
                            }
                            
                            $message = $number->sendText("+".$wa_id,"Escribe *el número* del recurso que quieres descargar o explorar:\n".$mensajes);
                            ResolveWhatsappRequest::setStatus($idUser,'Download');
                            
						}
						else{
						if($txtIn == 'video'){
							$message = $number->sendVideo("+".$wa_id,'https://conectarparaeducar.co/images/VideoInstrucciones.mp4','Instrucciones Retos');
						}
						else{
						if($txtIn == 'key'){
							$mensaje = "Tienes el reto *¿Qué caracteriza una experiencia pedagógica?* activo.  📚\n\nEl sistema está listo para recibir tu respuesta envía *exactamente* lo que te pedimos en las instrucciones. (Mensaje, Nota de Voz o Imagen)\n\n☝️*Consejo:* Si te pedimos un audio, envía únicamente el audio que responde al reto.";
							$message = $number->sendText('+573173319374',$mensaje);
						}
						else{
						if(ResolveWhatsappRequest::getStatus($idUser) == 'Download'){

							if($txtIn == 'inicio'){

								$message = $number->sendText("+".$wa_id,"📍¡Menú principal! \n\nEscribe *el número* de la opción que quieres explorar: \n\n*1* Quiero participar en ciclos de retos\n*2* Recursos y herramientas del ICBF y el MEN \n\n👉*Si ya iniciaste un ciclo de retos* escribe *RETO* para conocer el próximo.\n\nSi ya conoces tu reto, escribe la palabra *RESPONDER* si quieres enviar ya tu respuesta\n");
								ResolveWhatsappRequest::setStatus($idUser,'hola');

							}

							else{

							$resourceDownload = Resource::find($txtIn);
                                
                            ResolveWhatsappRequest::accessResource($txtIn,$idUser);

							if($resourceDownload->file){

								$sendType = $resourceDownload->file->mime_type;

								$expSendType = explode("/",$sendType);

								$typeMsg = $expSendType[0];

								if ($typeMsg == 'application') {

									$typeMsg = 'document';

								}

								switch($typeMsg){

									case "document":

										$message = $number->sendDocument('+'.$wa_id,$resourceDownload->file->getUrl() , $resourceDownload->name);

										ResolveWhatsappRequest::setStatus($idUser,'hola');

										break;

									case "image":

										$message = $number->sendImage('+'.$wa_id,$resourceDownload->file->getUrl() , $resourceDownload->name);

										ResolveWhatsappRequest::setStatus($idUser,'hola');

										break;

									case "audio":

										$message = $number->sendAudio('+'.$wa_id,$resourceDownload->file->getUrl());

										ResolveWhatsappRequest::setStatus($idUser,'hola');

										break;

									case "video":

										$message = $number->sendVideo('+'.$wa_id , $resourceDownload->file->getUrl(),$resourceDownload->name);

										logger($message->body());

										ResolveWhatsappRequest::setStatus($idUser,'hola');


										break;

								}
							}
							else{

								$message = $number->sendText('+'.$wa_id,"Accede al recurso a traves de este link: ".$resourceDownload->link);
							}

							ResolveWhatsappRequest::setStatus($idUser,'hola');
						}

						}
						else{

						if($status == 'encuesta'){

						}
						else{
							if($txtIn == 'temas'){

								$UserToRegister = User::find($idUser);

								if(!$UserToRegister->email_verified_at) {

									ResolveWhatsappRequest::setStatus($idUser,'hola');
									$message = $number->sendText("+".$wa_id,"Debes haber completado tu registro para conocer los temas. \n\nEscribe *INICIO* para volver al menu principal");


								}

								else{
									$sendTxt = "💥Estos son los temas en los que puedes realizar *ciclos de retos.*\n\n👇Escribe *el número* del tema en el que quieres fortalecer tu labor:\n\n";
									$loadBgProcesses = BackgroundProcess::get();
									foreach($loadBgProcesses as $loadBgProcess){
									$sendTxt .= "*".$loadBgProcess->id."* ".$loadBgProcess->name."\n";
									}
									$message = $number->sendText("+".$wa_id,$sendTxt);
									ResolveWhatsappRequest::setStatus($idUser,'BackgroundProcess');

							}

							}
							else{
								if($txtIn == 'mensaje'){
                                    
                                    if(!$courseMensaje = CoursesUser::where('user_id',$idUser)->where('actual_challenge',7)->first()){
                                        
                                        $message = $number->sendText("+".$wa_id,"No tienes disponible un mensaje en este momento");
                                    }
                                    else{

                                        $mensajeSelect = Course::find($courseMensaje->course_schedule->course->id);
                                        
                                        $message = $number->sendText("+".$wa_id,$mensajeSelect->mensaje_cierre);
                                        
                                        ResolveWhatsappRequest::setStatus($idUser,'hola');
                                        
                                    }
                                    
                                    
                                }
								else{

								if(ResolveWhatsappRequest::getStatus($idUser) == 'responder'){

									if((mb_strtolower($txtIn) == 'hola') or (mb_strtolower($txtIn) == 'aplazar')){

										ResolveWhatsappRequest::setStatus($idUser,'hola');
										$message = $number->sendText("+".$wa_id,"Has aplazado la opción de responder en este momento. Cuando estes listo escribe *RESPONDER* para enviar tu respuesta. Escribe INICIO para continuar");

									}
									else{
										if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->where('actual_challenge','>',0)->get()->count() > 0){

										$courseToDo = CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->where('actual_challenge','>',0)->first();

											if ($courseToDo->whatsapp_user == 1){

												if(ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$courseToDo->course_schedule_id)->get()->count() > 0){

													$challengeAnswer = ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$courseToDo->course_schedule_id)->first();

													if($challengeType = $challengeAnswer->challenge->referencetype->name == 'texto'){

														$updateChallenge = ChallengesUser::find($challengeAnswer->id);
														$updateChallenge->reference_text = $txtIn;
														$updateChallenge->status = 'Recibido';
														$updateChallenge->save();
														$courseUserToUpdate = CoursesUser::where('user_id',$idUser)->where('course_schedule_id',$challengeAnswer->courseschedule_id)->first();
														$updateCourse = CoursesUser::find($courseUserToUpdate->id);
														$updateCourse->actual_challenge = 0;
														$updateCourse->save();
														ResolveWhatsappRequest::setStatus($idUser,'hola');
														$message = $number->sendText("+".$wa_id,"🎉 ¡Felicitaciones, completaste el reto! 🎉\n\nPara solicitar el siguiente reto por favor envia la palabra *RETO* una vez sea habilitado\n\n❗️Si te equivocaste o quieres cambiar tu respuesta escribe la palabra *CAMBIAR* y sigue las instrucciones para enviar nuevamente tu respuesta.");

													}

												}
											}
											else{

												$message = sendText("+".$wa_id,"Recuerda que decidiste responder tus retos a través del Portal Web. Accede en esta dirección\n\nhttps://conectarparaeducar.co/mi-perfil");

											}
										}
									}
								}

								else{

									if(mb_strtolower($txtIn) == 'responder'){

		//							$message = $number->sendText("+".$wa_id,'El ciclo al que te has inscrito ha culminado');

										$actualCourse = CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->first();

										if(ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$actualCourse->course_schedule_id)->get()->count() < 1){

										$challengeAnswer = ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$actualCourse->course_schedule_id)->first();

										$message = $number->sendText('+'.$wa_id,"No tienes una respuesta pendiente para un reto o no te has inscrito a un ciclo de retos");
									}
									else{

										$challengeAnswer = ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$actualCourse->course_schedule_id)->first();

										$challengeType = $challengeAnswer->challenge->referencetype->name;

										$message = $number->sendText('+'.$wa_id,"El sistema se encuentra listo para recibir tu respuesta. Recuerda que para este reto, tu respuesta debe ser de tipo *".$challengeType."*\n\nSi envías una respuesta en un formato diferente a este, no será tenida en cuenta. Si aún no estás listo para responder, escribe *APLAZAR* y *solamente cuando estés listo* envía nuevamente la palabra *RESPONDER*");

										ResolveWhatsappRequest::setStatus($idUser,'responder');

									}

								}
								else{

									if(($txtIn == 'reto')){

										if(!ResolveWhatsappRequest::getStatus($idUser)) {
											ResolveWhatsappRequest::setStatus('hola');
										}

									if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','>',0)->where('actual_challenge','<',7)->get()->count() > 0){

										$courseToDo = CoursesUser::where('user_id',$idUser)->where('actual_challenge','>',0)->where('actual_challenge','<',7)->first();


											if ($courseToDo->whatsapp_user == 1){
                                                
                                                $courseChallenges = Challenge::where('course_id',$courseToDo->course_schedule->course->id)->skip(($courseToDo->actual_challenge-1))->first();
                                                
                                                $challengesCount = Challenge::where('course_id',$courseToDo->course_schedule->course->id)->get()->count();


												if(($challengesCount%2) == 0){

                                                    $messageToSendChallenge = "☝️*Recuerda*: cada semana, de martes a lunes, tienes 2 retos; cuando termines este reto, espera las instrucciones para responder el siguiente";
    
                                                }
                                                else{
                                            
                                                    $messageToSendChallenge = "☝️*Recuerda*: cada semana, de martes a lunes, tienes 1 reto; cuando termines este reto, espera las instrucciones para responder el siguiente";
                                            
                                                }

												$challengeMessage = "Tu reto a realizar se titula *".$courseChallenges->name."*\n\nLee o escucha en su totalidad la cápsula de conocimiento que te enviaré a continuación y lee con atención las instrucciones de principio a fin antes de comenzar:\n\nInstrucciones:\n\n".$courseChallenges->action_detail."\n\n".$messageToSendChallenge;

												if (ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$courseToDo->course_schedule_id)->get()->count() == 0){

													$initChallengeUser = new ChallengesUser;
													$initChallengeUser->status = 'Enviado';
													$initChallengeUser->courseschedule_id = $courseToDo->course_schedule_id;
													$initChallengeUser->user_id = $idUser;
													$initChallengeUser->challenge_id = $courseChallenges->id;
													$initChallengeUser->save();

												}

												$message = $number->sendText('+'.$wa_id,$challengeMessage);
												$attachmentType = ucfirst($courseChallenges->referencetype_capsule->code);
												$sendObject = 'send'.$attachmentType;
												if($attachmentType == 'Audio'){

													$filesend = $number->$sendObject('+'.$wa_id,$courseChallenges->capsule_file->getUrl());

												}
												else{
													if($attachmentType == 'Image'){

														$filesend = $number->sendImage('+'.$wa_id,$courseChallenges->capsule_file->getUrl());

													}
													else{

														$filesend = $number->sendDocument('+'.$wa_id,$courseChallenges->capsule_file->getUrl(),"Capsula de conocimiento");

													}

												}

												$messagecomp = $number->sendText('+'.$wa_id,"☝️ Recuerda que cuando tengas lista tu respuesta *deberas escribir primero* solamente la palabra *RESPONDER*  y enviarla. Luego el sistema te enviara un mensaje y te informará que esta listo y preparado para recibir tu respuesta.\n\nEsta es tu capsula de conocimiento:
												");


											}
											else{

											$message = $number->sendText('+'.$wa_id,"Recuerda que elegiste responder tus retos para este ciclo desde nuestro portal web.\n\nAccede desde https://conectarparaeducar.co/mi-perfil");

											}

									}

									else{

										$message = $number->sendText('+'.$wa_id,"ℹ️ Ya respondiste a tu último reto o aun no tienes retos pendientes de respuesta .\n\nRecuerda que siempre puedes escribir *INICIO* para ir al menu principal y conocer mucho mas de #ConectarParaEducar 📱\n\n");

									}



								}
								else{
								//validacion si respuesta existe en tabla de respuestas fijas
								if($answer = Whatsappword::where('word',$txtIn)->first()){

									//valida si palabra que entra corresponde a palabras clave del  menu de raiz
									if((mb_strtolower($txtIn) == 'hola') or (mb_strtolower($txtIn) == 'inicio') or (mb_strtolower($txtIn) == 'aceptar')){

										ResolveWhatsappRequest::setStatus($idUser,'hola');

									}

									//Valida y envia respuesta si pertenece a menu raiz de acuerdo a ubicación en el arbol de respuestas
									if(ResolveWhatsappRequest::getStatus($idUser) == 'hola'){

										$sendObj = 'send'.$answer->objeto;
										$sendTxt = strip_tags(ResolveWhatsappRequest::fixtxt($answer->message));
										if(!$sendLnk = $answer->link){
											$sendLnk = 'https://conectarparaeducar.co/images/wapp/hola.jpg';
										}
										if($answer->id == 5){
											$resourcesCategories = ResourcesCategory::get();

										}
										ResolveWhatsappRequest::setStatus($idUser,$answer->extra);

									}
									else{
                                        
                                        $status = ResolveWhatsappRequest::getStatus($idUser);


									if(is_numeric($txtIn)){
                                        
                                        
                                        if(($txtIn == '2') and (($status != 'name') or ($status != 'register') or ($status != 'InitRegister'))){
                                            
                                                $tagCategory = TagCategory::find(4)->load('tagCategoryTags');
                                                $tags = $tagCategory->tagCategoryTags;
                                                $mensajes = '';
                                                foreach($tags as $key => $tag){

                                                    $mensaje = "*".$tag->id.".* ".$tag->name."\n";
                                                    $mensajes = $mensajes.$mensaje;
                                                }

                                                $message = $number->sendText("+".$wa_id,"Escribe *el número* de la etiqueta que quieres explorar:\n".$mensajes);
                                                ResolveWhatsappRequest::setStatus($idUser,'Tags');

                                            
                                        }
                                                           
                                    else{


										if ($status == 'InitRegister'){

											$userUpdateDoctype = User::find($idUser);
											$userUpdateDoctype->documenttype_id = trim($txtIn);
											$userUpdateDoctype->save();
											$sendObj = 'sendText';
											ResolveWhatsappRequest::setStatus($idUser,'documenttype');
											$sendTxt = "Paso 2 de 4\n\n➡️Ahora escribe el número de tu documento sin puntos, comas, ni espacios.\n\n👉Al final del número escribe #\n\nEjemplo: 1234567890#";

										}
										else{

											if ($status == 'name'){

												switch ($txtIn){

													case 1:
													$InsertPlaceRole = 'ICBF';
													break;

													case 2:
													$InsertPlaceRole = 'IED';
													break;

													case 3:
													$InsertPlaceRole = 'EXTERNO';
													break;

													default:
													$InsertPlaceRole = 'EXTERNO';

												}

												$userUpdatePlacerole = User::find($idUser);
												$userUpdatePlacerole->place_role = $InsertPlaceRole;

												if($userUpdatePlacerole->save()){

													$userVerify = User::find($idUser);
													$userVerify->email_verified_at = date("Y-m-d H:i:s");
													$userVerify->save();

												}
												$sendObj = 'sendText';

												$sendTxt = "✅ ¡Has completado tu registro! \n\n💥Estas son las temáticas en las que puedes realizar *ciclos de retos.*\n\n👇Escribe *el número* del tema en el que quieres fortalecer tu labor:\n\n";
                                                $loadBgProcesses = BackgroundProcess::get();
												foreach($loadBgProcesses as $loadBgProcess){

													$sendTxt .= "*".$loadBgProcess->id."* ".$loadBgProcess->name."\n";
                                                }
                                                
                                                ResolveWhatsappRequest::setStatus($idUser,'BackgroundProcess');
											}

											else{
											$add = '';
											switch($status){

												case "hola":
													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 3;
													break;

												case "register":
													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 2;
													break;

												case "BackgroundProcess":

													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 0;
													break;

												case "Event":
													$txtObj = "Eventos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 0;
													break;

												case "ResourcesSubcategory":
													$txtObj = "Recursos y herramientas";
													$statusObj = 'ResourcesSubcategory';
													$fieldObj = 'name';
													$last = 5;
													break;

												case "Tag":
													$txtObj = "Recursos y herramientas";
													$statusObj = 'Resources';
													$fieldObj = 'name';
													$last = 6;
													break;										

												case "Course":
													$txtObj = "Ciclo de retos";
													$statusObj = 'CourseSchedule';
													$fieldObj = 'name';
													$last = 1;
													break;

												}

												$status = ResolveWhatsappRequest::getStatus($idUser);
												$pref = 'App\Models';
												$model = $pref."\\".$statusObj;
												$sendObj = 'sendText';
                                                $sendTxt = "Estos son los ".$txtObj." que puedes seleccionar:\n*Escribe el número* que corresponda al de tu interés:\n\n";
												if ($last == 0) {
													$courses = $model::where('tematica_asociada_id',$txtIn)->get();
                                                    foreach($courses as $course){
                                                        
                                                        if(CourseSchedule::where('start_date','>',date("Y-m-d")->where('course_id',$course->id)->first())){
                                                            
                                                            $sendTxt .= "*".$element->id."* ".$element->$fieldObj."\n";
                                                            
                                                        }
                                                        
                                                    }

												}

												if($last == 1 ){

													if($elements = $model::where('course_id',$txtIn)->where('start_date','>',date("Y-m-d"))->orderBy('start_date','ASC')->first()){
														$sendTxt = "📍El ciclo *".$elements->course->name."* te ayudará a fortalecer tu labor en el tema que seleccionaste.\n\nEste ciclo iniciará el día ".fechaEs($elements->start_date)."\n\n".$elements->course->goal." y tendra una duración de 4 semanas\n\nEscribe la palabra *QUIERO* para inscribirte en este ciclo de retos 🙌🏽\n\n☝️Recuerda que en cualquier momento puedes escribir la palabra *TEMAS* para volver a las temáticas disponibles";               
                                                        //$sendTxt = "📍El ciclo *".$elements->course->name."* te ayudará a fortalecer tu labor en el tema que seleccionaste.\n\nEste ciclo iniciará el día ".fechaEs($elements->start_date)."\n\n".$elements->course->goal." y tendra una duración de 4 semanas\n\nEscribe la palabra *QUIERO* para inscribirte en este ciclo de retos o la palabra *UNO* para recibir el reto único de este ciclo! 🙌🏽\n\n☝️Recuerda que en cualquier momento puedes escribir la palabra *TEMAS* para volver a las temáticas disponibles";											
                                                        $add = "|".$elements->id;
													}
													else{
														$sendTxt = "En este momento no hay programación para este ciclo. Te invitamos a consultar en un futuro esta sección para verificar su disponibilidad de inscripciones.\n\nEnvia la palabra *INICIO* para regresar al menú principal";
														$statusObj = 'hola';
													}

												}

												if ($last == 2){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe *REGISTRAR* para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'register';
												}

												if ($last == 3){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe la opción correcta para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'hola';
												}

												if ($last == 4){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe la opción correcta para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'hola';
												}
												if ($last == 5){

													$resourcesSubcats = ResourcesSubcategory::where('resourcescategory_id',$txtIn)->get();
													$sendTxt = "🛠️Escribe el número de la subcategoría de recursos que quieres explorar: \n\n";

													foreach($resourcesSubcats as $resourcesSubcat){
														$sendTxt .= "*".$resourcesSubcat->id."* ".$resourcesSubcat->name."\n";
													}
													
												}
												if ($last == 6){
                                                    
                                                    //Por cambio en forma de mostrar Recursos solo por etiquetas
                                                    
                                                    if($txtIn<=16){
                                                        
                                                        $txtIn = $txtIn+10;
                                                        
                                                    }
                                                    else{
                                                        
                                                        $txtIn = $txtIn+12;
                                                        
                                                    }
                                                    
                                                    $tagTarget = Tag::find($txtIn);
                                                    $tagElements = $tagTarget->load('tag_category', 'tagsResources');
                                                    $resourcesCheck = $tagElements->tagsResources;
													$counterpages = count($resourcesCheck);
													$sendTxt = "🛠️Escribe el número del recurso/herramienta que quieres consultar:  \n\n";
                                                    foreach($resourcesCheck as $resource){
                                                        $sendTxt .= "*".$resource->id."* ".$resource->name."\n";
                                                    }

													$statusObj = 'Download';
												}

												ResolveWhatsappRequest::setStatus($idUser,$statusObj.$add);
											}
										}
									}}
									//Si no es numerica validar objeto de entrada y tramitar acciones
									else{
										//validacion importante QUIERO
										if($txtIn == 'quiero'){

											$status = ResolveWhatsappRequest::getStatus($idUser);
											$courseExplode = explode("|",$status);
											$courseInsertId = $courseExplode[1];
											$courseRegisters = CoursesUser::where('course_schedule_id',$courseInsertId)->get()->count();
											$courseLimit = CourseSchedule::where('id',$courseInsertId)->first();

											if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->get()->count()>0){

												$sendObj = 'sendText';
												$sendTxt = "No podemos realizar tu inscripción en este momento. 😔 Recuerda que solo puedes estar inscrito a un ciclo de retos a la vez. Te esperamos una vez termines tu ciclo actual, para participar de más ofertas 🤓\n\nEscribe la palabra *INICIO* para ir al menú principal";
												ResolveWhatsappRequest::setStatus($idUser,'hola');

											}
											else{


													$insertCourseUser = new CoursesUser;
													$insertCourseUser->whatsapp_user = 1;
													$insertCourseUser->user_id = $idUser;
													$insertCourseUser->course_schedule_id = $courseInsertId;
													$insertCourseUser->course_name = $courseLimit->course->name;
													$insertCourseUser->actual_challenge = 0;
													$insertCourseUser->save();
													$sendObj = 'sendText';
													$sendTxt = "✅¡Felicitaciones ".$name."! Te has inscrito en el ciclo de retos *".$courseLimit->course->name."*, el cual comienza el ".fechaEs($courseLimit->start_date).". ✨\n\nEse día recibirás un mensaje de bienvenida y tu primer reto. 📬\n\nRecuerda que puedes escribir *INICIO* para regresar al menú principal y explorar mucho más de lo que tenemos para ti.";
													ResolveWhatsappRequest::setStatus($idUser,'hola');

								

											}

										}
										else{



										if (ResolveWhatsappRequest::getStatus($idUser) == 'register'){

												$UserToRegister = User::find($idUser);

												if(!$UserToRegister->email_verified_at){

													$sendObj = 'sendText';
													$sendTxt = "➡️Escribe *el número que acompaña* a la opción que corresponde a tu tipo de documento:\n\n";
													$loadDocTypes = DocumentType::get();
													foreach($loadDocTypes as $loadDocType){

														$sendTxt .= "*".$loadDocType->id."* ".$loadDocType->name."\n";

													}
													ResolveWhatsappRequest::setStatus($idUser,'InitRegister');

												}
												else{

													$sendObj = 'sendText';
													$sendTxt = "✅Ya eres un usuario registrado en nuestra plataforma\n\n💥Estos son los temas en los que puedes realizar *ciclos de retos.*\n\n👇Escribe *el número* del tema en el que quieres fortalecer tu labor:\n\n";
									                $loadBgProcesses = BackgroundProcess::get();
													foreach($loadBgProcesses as $loadBgProcess){

													$sendTxt .= "*".$loadBgProcess->id."* ".$loadBgProcess->name."\n";
                                                    }

												ResolveWhatsappRequest::setStatus($idUser,'hola');
											}
										}
										else{

											if (ResolveWhatsappRequest::getStatus($idUser) == 'documenttype'){

												$insertDocument = strstr($txtIn, '#', true);
												$userUpdateDoc = User::find($idUser);
												$userUpdateDoc->document = $insertDocument;
												$userUpdateDoc->save();
												$sendObj = 'sendText';
												ResolveWhatsappRequest::setStatus($idUser,'document');
												$sendTxt = "Paso 3 de 4\n\n☝️Ahora, escribe tu nombre y apellido y finaliza con el símbolo %\n\nEjemplo: Tania Castillo%";

											}

											else{

												if (ResolveWhatsappRequest::getStatus($idUser) == 'document'){

													$insertName = strstr($txtIn, '%', true);
													$userUpdateName= User::find($idUser);
													$userUpdateName->name = mb_strtoupper($insertName);
													$userUpdateName->save();
													$sendObj = 'sendText';

													ResolveWhatsappRequest::setStatus($idUser,'name');
													$sendTxt = "Paso 4 de 4\n\n¡Ya casi completamos tu registro! ✍️\n\n➡️Por último, indícanos \n¿Dónde ejerces tu labor? (digita *sólo el numero* que corresponda):\n\n";

													$count = 1;
													foreach(User::PLACE_ROLE_SELECT as $key => $label){
														$sendTxt .= "*".$count."* ".$label."\n";
														$count = $count +1;
													}
												}
												else{

													if(ResolveWhatsappRequest::getStatus($idUser) == 'CourseSchedule'){



													}
													else{

														$sendObj = 'sendText';
														$sendTxt = $invalid;

													}

												}

											}
										}

									}//Cierre quiero
									}


									}

								}
								//En caso de no pertenecer, validar si repuesta es numerica para tramitar acciones específicas
								else{

									if(is_numeric($txtIn)){

										$status = ResolveWhatsappRequest::getStatus($idUser);

										if ($status == 'InitRegister'){

											$userUpdateDoctype = User::find($idUser);
											$userUpdateDoctype->documenttype_id = trim($txtIn);
											$userUpdateDoctype->save();
											$sendObj = 'sendText';
											ResolveWhatsappRequest::setStatus($idUser,'documenttype');
											$sendTxt = "➡️Ahora escribe el número de tu documento sin puntos, comas, ni espacios.\n\n👉Al final del número escribe #\n\nEjemplo: 1234567890#";

										}
										else{

											if (ResolveWhatsappRequest::getStatus($idUser) == 'name'){

												switch ($txtIn){

													case 1:
													$InsertPlaceRole = 'ICBF';
													break;

													case 2:
													$InsertPlaceRole = 'IED';
													break;

													case 3:
													$InsertPlaceRole = 'EXTERNO';
													break;

													default:
													$InsertPlaceRole = 'EXTERNO';

												}

												$userUpdatePlacerole = User::find($idUser);
												$userUpdatePlacerole->place_role = $InsertPlaceRole;

												if($userUpdatePlacerole->save()){

													$userVerify = User::find($idUser);
													$userVerify->email_verified_at = date("Y-m-d H:i:s");
													$userVerify->save();

												}
												$sendObj = 'sendText';

												$sendTxt = "✅ ¡Has completado tu registro! \n\n💥Estas son las temáticas en las que puedes realizar *ciclos de retos.*\n\n👇Escribe *el número* del tema en el que quieres fortalecer tu labor:\n\n";
                                                $loadBgProcesses = BackgroundProcess::get();
													foreach($loadBgProcesses as $loadBgProcess){

													$sendTxt .= "*".$loadBgProcess->id."* ".$loadBgProcess->name."\n";
                                                }
                                                
                                                ResolveWhatsappRequest::setStatus($idUser,'BackgroundProcess');

											}

											else{
											$add = '';
											switch($status){

												case "hola":
													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 3;
													break;

												case "register":
													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 2;
													break;

												case "BackgroundProcess":

													$txtObj = "Ciclos de retos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 0;
													break;

												case "Event":
													$txtObj = "Eventos";
													$statusObj = 'Course';
													$fieldObj = 'name';
													$last = 4;
													break;

												case "ResourcesSubcategory":
													$txtObj = "Recursos y herramientas";
													$statusObj = 'ResourcesSubcategory';
													$fieldObj = 'name';
													$last = 5;
													break;

												case "Tag":
													$txtObj = "Recursos y herramientas";
													$statusObj = 'Resources';
													$fieldObj = 'name';
													$last = 6;
													break;

												case "Course":
													$txtObj = "Ciclo de retos";
													$statusObj = 'CourseSchedule';
													$fieldObj = 'name';
													$last = 1;
													break;

												}

												$status = ResolveWhatsappRequest::getStatus($idUser);
												$pref = 'App\Models';
												$model = $pref."\\".$statusObj;
												$sendObj = 'sendText';
                                                $sendTxt = "Estos son los ".$txtObj." que puedes seleccionar:\n*Escribe el número* que corresponda al de tu interés:\n\n";
												if ($last == 0) {
													$courses = $model::where('tematica_asociada_id',$txtIn)->get();
                                                    foreach($courses as $course){
                                                        
                                                        if(CourseSchedule::where('start_date','>',date("Y-m-d"))->where('course_id',$course->id)->first()){
                                                            
                                                            $sendTxt .= "*".$course->id."* ".$course->$fieldObj."\n";
                                                            
                                                        }
                                                        
                                                    }

												}


												if($last == 1 ){
													if($elements = $model::where('course_id',$txtIn)->where('start_date','>',date("Y-m-d"))->orderBy('start_date','ASC')->first()){
														$sendTxt = "📍El ciclo *".$elements->course->name."* te ayudará a fortalecer tu labor en el tema que seleccionaste.\n\nEste ciclo iniciará el día ".fechaEs($elements->start_date)."\n\n".$elements->course->goal." y tendra una duración de 4 semanas\n\nEscribe la palabra *QUIERO* para inscribirte en este ciclo de retos";
														//$sendTxt = "📍El ciclo *".$elements->course->name."* te ayudará a fortalecer tu labor en el tema que seleccionaste.\n\nEste ciclo iniciará el día ".fechaEs($elements->start_date)."\n\n".$elements->course->goal." y tendra una duración de 4 semanas\n\nEscribe la palabra *QUIERO* para inscribirte en este ciclo de retos o la palabra *UNO* para recibir el reto único de este ciclo";														
                                                        $add = "|".$elements->id;
													}
													else{
														$sendTxt = "En este momento no hay programación para este ciclo. Te invitamos a consultar en un futuro esta sección para verificar su disponibilidad de inscripciones.\n\nEnvia la palabra *INICIO* para regresar al menú principal";
														$statusObj = 'hola';
													}
												}

												if ($last == 2){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe *REGISTRAR* para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'register';
												}

												if ($last == 3){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe la opción correcta para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'hola';
												}
												if ($last == 4){

													$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe la opción correcta para continuar el proceso o *INICIO* para volver al menú principal";
													$statusObj = 'hola';
												}

												if ($last == 5){

													$resourcesSubcats = ResourcesSubcategory::where('resourcescategory_id',$txtIn)->get();
													$sendTxt = "🛠️Escribe el número de la subcategoría de recursos que quieres explorar: \n\n";

													foreach($resourcesSubcats as $resourcesSubcat){
														$sendTxt .= "*".$resourcesSubcat->id."* ".$resourcesSubcat->name."\n";
													}

													$statusObj = 'Resources';
												}

												if ($last == 6){
                                                    
                                                    //Por cambio en forma de mostrar Recursos solo por etiquetas
                                                    
                                                    if($txtIn<=16){
                                                        
                                                        $txtIn = $txtIn+10;
                                                        
                                                    }
                                                    else{
                                                        
                                                        $txtIn = $txtIn+12;
                                                        
                                                    }
                                                    
                                                    $tagTarget = Tag::find($txtIn);
                                                    $tagElements = $tagTarget->load('tag_category', 'tagsResources');
                                                    $resourcesCheck = $tagElements->tagsResources;
													$counterpages = count($resourcesCheck);
													$sendTxt = "🛠️Escribe el número del recurso/herramienta que quieres consultar:  \n\n";
                                                    foreach($resourcesCheck as $resource){
                                                        $sendTxt .= "*".$resource->id."* ".$resource->name."\n";
                                                    }

													$statusObj = 'Download';
												}								

												ResolveWhatsappRequest::setStatus($idUser,$statusObj.$add);
											}
										}
									}
									//Si no es numerica validar objeto de entrada y tramitar acciones
									else{
										if($txtIn == 'quiero'){

											$status = ResolveWhatsappRequest::getStatus($idUser);

											if($status == 'hola'){

												$sendObj = 'sendText';
												$sendTxt = "🚫 Esta no es una palabra o número válido para este menu.\n\nEscribe la opción correcta para continuar el proceso o *INICIO* para volver al menú principal";
												ResolveWhatsappRequest::setStatus($idUser,'hola');

											}
											else{

								            $courseExplode = explode("|",$status);
											$courseInsertId = $courseExplode[1];
											$courseRegisters = CoursesUser::where('course_schedule_id',$courseInsertId)->get()->count();
											$courseLimit = CourseSchedule::where('id',$courseInsertId)->first();
											if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->get()->count()>0){


												$sendObj = 'sendText';
												$sendTxt = "No podemos realizar tu inscripción en este momento. 😔 Recuerda que solo puedes estar inscrito a un ciclo de retos a la vez. Te esperamos una vez termines tu ciclo actual, para participar de más ofertas 🤓\n\nEscribe la palabra *INICIO* para ir al menú principal";
												ResolveWhatsappRequest::setStatus($idUser,'hola');


											}
											else{



													$insertCourseUser = new CoursesUser;
													$insertCourseUser->whatsapp_user = 1;
													$insertCourseUser->user_id = $idUser;
													$insertCourseUser->course_schedule_id = $courseInsertId;
													$insertCourseUser->course_name = $courseLimit->course->name;
													$insertCourseUser->actual_challenge = 0;
                                                    $insertCourseUser->alert_messages = 'sms';
                                                    $insertCourseUser->status = 'Inscrito';
													$insertCourseUser->save();
													$sendObj = 'sendText';
													$sendTxt = "✅¡Felicitaciones ".$name."! Te has inscrito en el ciclo de retos *".$courseLimit->course->name."*, el cual comienza el ".fechaEs($courseLimit->start_date).". ✨\n\nEse día recibirás un mensaje de bienvenida y tu primer reto. 📬\n\nRecuerda que puedes escribir *INICIO* para regresar al menú principal y explorar mucho más de lo que tenemos para ti.";
													ResolveWhatsappRequest::setStatus($idUser,'hola');


												

											}
											}

										}

										else{
										if (ResolveWhatsappRequest::getStatus($idUser) == 'register'){

												$UserToRegister = User::find($idUser);
												if(!$UserToRegister->email_verified_at){

													$sendObj = 'sendText';
													$sendTxt = "Paso 1 de 4\n\n➡️Escribe *el número que acompaña* a la opción que corresponde a tu tipo de documento:\n\n";
													$loadDocTypes = DocumentType::get();
													foreach($loadDocTypes as $loadDocType){

														$sendTxt .= "*".$loadDocType->id."* ".$loadDocType->name."\n";

													}
													ResolveWhatsappRequest::setStatus($idUser,'InitRegister');

												}
											    else{

												$sendObj = 'sendText';
												$sendTxt = "✅Ya eres un usuario registrado en nuestra plataforma\n\n💥Estos son los temas en los que puedes realizar *ciclos de retos.*\n\n👇Escribe *el número* del tema en el que quieres fortalecer tu labor:\n\n";
									            $loadBgProcesses = BackgroundProcess::get();
												foreach($loadBgProcesses as $loadBgProcess){

													$sendTxt .= "*".$loadBgProcess->id."* ".$loadBgProcess->name."\n";

												}

												ResolveWhatsappRequest::setStatus($idUser,'BackgroundProcess');
											}
										}
										else{

											if (ResolveWhatsappRequest::getStatus($idUser) == 'documenttype'){

												$insertDocument = strstr($txtIn, '#', true);
												$userUpdateDoc = User::find($idUser);
												$userUpdateDoc->document = $insertDocument;
												$userUpdateDoc->save();
												$sendObj = 'sendText';
												ResolveWhatsappRequest::setStatus($idUser,'document');
												$sendTxt = "☝️Ahora, escribe tu nombre y apellido y finaliza con el símbolo %\n\nEjemplo: Tania Castillo%";

											}

											else{

												if (ResolveWhatsappRequest::getStatus($idUser) == 'document'){

													$insertName = strstr($txtIn, '%', true);
													$userUpdateName= User::find($idUser);
													$userUpdateName->name = mb_strtoupper($insertName);
													$userUpdateName->save();
													$sendObj = 'sendText';

													ResolveWhatsappRequest::setStatus($idUser,'name');
													$sendTxt = "¡Ya casi completamos tu registro! ✍️\n\n➡️Por último, indícanos \n¿Dónde ejerces tu labor? (digita *sólo el numero* que corresponda):\n\n";

													$count = 1;
													foreach(User::PLACE_ROLE_SELECT as $key => $label){
														$sendTxt .= "*".$count."* ".$label."\n";
														$count = $count +1;
													}
												}
												else{

													$sendObj = 'sendText';
													$sendTxt = $invalid;

												}

											}
										}

										}
									}


								}//Cierre no pertenecer
								}

								}
								}


								if($sendObj!='sendText') {

									if(!@$sendTxt) $sendTxt = "Escribiste una opción no valida. Escribe y envia *INICIO* para continuar";
									if(!@$sendLnk) $sendLnk = "Gracias";


									$message = $number->sendImage('+'.$wa_id,$sendLnk,urldecode($sendTxt));

									}

								else{

									$message = $number->$sendObj('+'.$wa_id,urldecode(strip_tags($sendTxt)));

								}

								logger($message->body());

								}
						}
						}
						}
						}
						}
						}
					}
				}
                }
			}
			else{

				if(ResolveWhatsappRequest::getStatus($idUser) == 'responder'){

					if(CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->where('actual_challenge','>',0)->get()->count() > 0){
						
						$courseToDo = CoursesUser::where('user_id',$idUser)->where('actual_challenge','<',7)->where('actual_challenge','>',0)->first();
						
						if ($courseToDo->whatsapp_user == 1){

							if(ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$courseToDo->course_schedule_id)->get()->count() > 0){
								
								$challengeAnswer = ChallengesUser::where('user_id',$idUser)->where('status','Enviado')->where('courseschedule_id',$courseToDo->course_schedule_id)->first();

								$challengeType = $challengeAnswer->challenge->referencetype->name;

								$response = $number->getMedia($this->data['messages'][0][$contentType]['id']);

								switch($contentType){

                                    case "voice":
                                        
                                        $extension = "ogg";

										break;
                                        
                                    
                                    case "audio":

										$extension = "mp4";

										break;

									case "video":

										$extension = "mp4";

										break;

									case "image":

										$extension = "jpeg";

										break;

									case "document":

										$sendType = $this->data['messages'][0]['document']['mime_type'];

										$expSendType = explode("/",$sendType);

										if($expSendType == 'plain'){

											$extension = 'txt';
										}

										else{

											if ($expSendType[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document'){

												$extension = 'docx';
											}
											else{

												$extension = $expSendType[1];

											}

										}

										break;

									case "voice":

										$extension = 'ogg';

										break;

								}


								$mediaid = $this->data['messages'][0][$contentType]['id'];
                                
                                $uploadFile = Storage::disk('respuestas')->put($mediaid.".".$extension,$response->body());

								if($uploadFile){

									$carga = ChallengesUser::find($challengeAnswer->id);

									$carga->reference_media = '<a target="_blank" href="'.env('APP_URL').'/storage/respuestas/'.$mediaid.'.'.$extension.'" >Ver Archivo</a>';

									$carga->status = 'Recibido';

									if($carga->save()) {
										

										ResolveWhatsappRequest::setstatus($idUser,'hola');

										$courseUserToUpdate = CoursesUser::where('user_id',$idUser)->where('course_schedule_id',$challengeAnswer->courseschedule_id)->first();
                                        $challengesCourse = Challenge::where('course_id',$courseUserToUpdate->course_schedule->course->id)->get()->count();
                                        if($challengesCourse % 2 == 0){
                                            
                                            $messageToSend = "☝️*Recuerda*: cada semana, de martes a lunes, tienes 2 retos; cuando termines este reto te llegarán las instrucciones para responder el siguiente";
    
                                        }
                                        else{
                                            
                                            $messageToSend = "☝️*Recuerda*: cada semana, de martes a lunes, tienes 1 reto; cuando termines este reto espera las instrucciones para responder el siguiente";
                                            
                                        }
                                        
										$updateCourse = CoursesUser::find($courseUserToUpdate->id);
										$updateCourse->actual_challenge = 0;
										$updateCourse->save();
										
										$message = $number->sendText('+'.$wa_id,"🎉 ¡Felicitaciones, completaste el reto! 🎉\n\n".$messageToSend."\n\n❗Si te equivocaste o quieres cambiar tu respuesta escribe la palabra CAMBIAR y sigue las instrucciones para enviarla nuevamente");

									}
								}

							}
						}
						else{

							$message = $number->sendTxt("+".$wa_id,"Recuerda que decidiste responder tus retos a través del Portal Web. Accede en esta dirección\n\nhttps://conectarparaeducar.co/mi-perfil");

						}
					}

					else{
						$message = $number->sendText("+".$wa_id,"Si vas a enviar la respuesta a un reto, envia *unicamente* la palabra *RESPONDER* para que el sistema te confirme que esta listo para que envies tu respuesta\n\nTambien puedes enviar la palabra *INICIO* para acceder al menú principal");
					}

				}

				else{
						$message = $number->sendText("+".$wa_id,"Si vas a enviar la respuesta a un reto, envia *unicamente* la palabra *RESPONDER* para que el sistema te confirme que esta listo para que envies tu respuesta\n\nTambien puedes enviar la palabra *INICIO* para acceder al menú principal");

				}

			}

    	}

	}

}
