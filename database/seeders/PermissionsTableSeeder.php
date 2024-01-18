<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'global_var_access',
            ],
            [
                'id'    => 24,
                'title' => 'department_create',
            ],
            [
                'id'    => 25,
                'title' => 'department_edit',
            ],
            [
                'id'    => 26,
                'title' => 'department_show',
            ],
            [
                'id'    => 27,
                'title' => 'department_delete',
            ],
            [
                'id'    => 28,
                'title' => 'department_access',
            ],
            [
                'id'    => 29,
                'title' => 'city_create',
            ],
            [
                'id'    => 30,
                'title' => 'city_edit',
            ],
            [
                'id'    => 31,
                'title' => 'city_show',
            ],
            [
                'id'    => 32,
                'title' => 'city_delete',
            ],
            [
                'id'    => 33,
                'title' => 'city_access',
            ],
            [
                'id'    => 34,
                'title' => 'device_create',
            ],
            [
                'id'    => 35,
                'title' => 'device_edit',
            ],
            [
                'id'    => 36,
                'title' => 'device_show',
            ],
            [
                'id'    => 37,
                'title' => 'device_delete',
            ],
            [
                'id'    => 38,
                'title' => 'device_access',
            ],
            [
                'id'    => 39,
                'title' => 'document_type_create',
            ],
            [
                'id'    => 40,
                'title' => 'document_type_edit',
            ],
            [
                'id'    => 41,
                'title' => 'document_type_show',
            ],
            [
                'id'    => 42,
                'title' => 'document_type_delete',
            ],
            [
                'id'    => 43,
                'title' => 'document_type_access',
            ],
            [
                'id'    => 44,
                'title' => 'educational_background_access',
            ],
            [
                'id'    => 45,
                'title' => 'background_process_create',
            ],
            [
                'id'    => 46,
                'title' => 'background_process_edit',
            ],
            [
                'id'    => 47,
                'title' => 'background_process_show',
            ],
            [
                'id'    => 48,
                'title' => 'background_process_delete',
            ],
            [
                'id'    => 49,
                'title' => 'background_process_access',
            ],
            [
                'id'    => 50,
                'title' => 'reference_type_create',
            ],
            [
                'id'    => 51,
                'title' => 'reference_type_edit',
            ],
            [
                'id'    => 52,
                'title' => 'reference_type_show',
            ],
            [
                'id'    => 53,
                'title' => 'reference_type_delete',
            ],
            [
                'id'    => 54,
                'title' => 'reference_type_access',
            ],
            [
                'id'    => 55,
                'title' => 'entity_create',
            ],
            [
                'id'    => 56,
                'title' => 'entity_edit',
            ],
            [
                'id'    => 57,
                'title' => 'entity_show',
            ],
            [
                'id'    => 58,
                'title' => 'entity_delete',
            ],
            [
                'id'    => 59,
                'title' => 'entity_access',
            ],
            [
                'id'    => 60,
                'title' => 'self_interested_access',
            ],
            [
                'id'    => 61,
                'title' => 'courses_hook_create',
            ],
            [
                'id'    => 62,
                'title' => 'courses_hook_edit',
            ],
            [
                'id'    => 63,
                'title' => 'courses_hook_show',
            ],
            [
                'id'    => 64,
                'title' => 'courses_hook_delete',
            ],
            [
                'id'    => 65,
                'title' => 'courses_hook_access',
            ],
            [
                'id'    => 66,
                'title' => 'course_create',
            ],
            [
                'id'    => 67,
                'title' => 'course_edit',
            ],
            [
                'id'    => 68,
                'title' => 'course_show',
            ],
            [
                'id'    => 69,
                'title' => 'course_delete',
            ],
            [
                'id'    => 70,
                'title' => 'course_access',
            ],
            [
                'id'    => 71,
                'title' => 'challenge_create',
            ],
            [
                'id'    => 72,
                'title' => 'challenge_edit',
            ],
            [
                'id'    => 73,
                'title' => 'challenge_show',
            ],
            [
                'id'    => 74,
                'title' => 'challenge_delete',
            ],
            [
                'id'    => 75,
                'title' => 'challenge_access',
            ],
            [
                'id'    => 76,
                'title' => 'programacion_de_ciclo_access',
            ],
            [
                'id'    => 77,
                'title' => 'course_schedule_create',
            ],
            [
                'id'    => 78,
                'title' => 'course_schedule_edit',
            ],
            [
                'id'    => 79,
                'title' => 'course_schedule_show',
            ],
            [
                'id'    => 80,
                'title' => 'course_schedule_delete',
            ],
            [
                'id'    => 81,
                'title' => 'course_schedule_access',
            ],
            [
                'id'    => 82,
                'title' => 'courses_user_create',
            ],
            [
                'id'    => 83,
                'title' => 'courses_user_edit',
            ],
            [
                'id'    => 84,
                'title' => 'courses_user_show',
            ],
            [
                'id'    => 85,
                'title' => 'courses_user_delete',
            ],
            [
                'id'    => 86,
                'title' => 'courses_user_access',
            ],
            [
                'id'    => 87,
                'title' => 'challenges_user_create',
            ],
            [
                'id'    => 88,
                'title' => 'challenges_user_edit',
            ],
            [
                'id'    => 89,
                'title' => 'challenges_user_show',
            ],
            [
                'id'    => 90,
                'title' => 'challenges_user_delete',
            ],
            [
                'id'    => 91,
                'title' => 'challenges_user_access',
            ],
            [
                'id'    => 92,
                'title' => 'resources_library_access',
            ],
            [
                'id'    => 93,
                'title' => 'resources_category_create',
            ],
            [
                'id'    => 94,
                'title' => 'resources_category_edit',
            ],
            [
                'id'    => 95,
                'title' => 'resources_category_show',
            ],
            [
                'id'    => 96,
                'title' => 'resources_category_delete',
            ],
            [
                'id'    => 97,
                'title' => 'resources_category_access',
            ],
            [
                'id'    => 98,
                'title' => 'resources_subcategory_create',
            ],
            [
                'id'    => 99,
                'title' => 'resources_subcategory_edit',
            ],
            [
                'id'    => 100,
                'title' => 'resources_subcategory_show',
            ],
            [
                'id'    => 101,
                'title' => 'resources_subcategory_delete',
            ],
            [
                'id'    => 102,
                'title' => 'resources_subcategory_access',
            ],
            [
                'id'    => 103,
                'title' => 'tag_category_create',
            ],
            [
                'id'    => 104,
                'title' => 'tag_category_edit',
            ],
            [
                'id'    => 105,
                'title' => 'tag_category_show',
            ],
            [
                'id'    => 106,
                'title' => 'tag_category_delete',
            ],
            [
                'id'    => 107,
                'title' => 'tag_category_access',
            ],
            [
                'id'    => 108,
                'title' => 'tag_create',
            ],
            [
                'id'    => 109,
                'title' => 'tag_edit',
            ],
            [
                'id'    => 110,
                'title' => 'tag_show',
            ],
            [
                'id'    => 111,
                'title' => 'tag_delete',
            ],
            [
                'id'    => 112,
                'title' => 'tag_access',
            ],
            [
                'id'    => 113,
                'title' => 'resource_create',
            ],
            [
                'id'    => 114,
                'title' => 'resource_edit',
            ],
            [
                'id'    => 115,
                'title' => 'resource_show',
            ],
            [
                'id'    => 116,
                'title' => 'resource_delete',
            ],
            [
                'id'    => 117,
                'title' => 'resource_access',
            ],
            [
                'id'    => 118,
                'title' => 'event_access',
            ],
            [
                'id'    => 119,
                'title' => 'events_schedule_create',
            ],
            [
                'id'    => 120,
                'title' => 'events_schedule_edit',
            ],
            [
                'id'    => 121,
                'title' => 'events_schedule_show',
            ],
            [
                'id'    => 122,
                'title' => 'events_schedule_delete',
            ],
            [
                'id'    => 123,
                'title' => 'events_schedule_access',
            ],
            [
                'id'    => 124,
                'title' => 'events_attendant_create',
            ],
            [
                'id'    => 125,
                'title' => 'events_attendant_edit',
            ],
            [
                'id'    => 126,
                'title' => 'events_attendant_show',
            ],
            [
                'id'    => 127,
                'title' => 'events_attendant_delete',
            ],
            [
                'id'    => 128,
                'title' => 'events_attendant_access',
            ],
            [
                'id'    => 129,
                'title' => 'community_access',
            ],
            [
                'id'    => 130,
                'title' => 'technical_referrer_create',
            ],
            [
                'id'    => 131,
                'title' => 'technical_referrer_edit',
            ],
            [
                'id'    => 132,
                'title' => 'technical_referrer_show',
            ],
            [
                'id'    => 133,
                'title' => 'technical_referrer_delete',
            ],
            [
                'id'    => 134,
                'title' => 'technical_referrer_access',
            ],
            [
                'id'    => 135,
                'title' => 'meeting_create',
            ],
            [
                'id'    => 136,
                'title' => 'meeting_edit',
            ],
            [
                'id'    => 137,
                'title' => 'meeting_show',
            ],
            [
                'id'    => 138,
                'title' => 'meeting_delete',
            ],
            [
                'id'    => 139,
                'title' => 'meeting_access',
            ],
            [
                'id'    => 140,
                'title' => 'meeting_attendant_create',
            ],
            [
                'id'    => 141,
                'title' => 'meeting_attendant_edit',
            ],
            [
                'id'    => 142,
                'title' => 'meeting_attendant_show',
            ],
            [
                'id'    => 143,
                'title' => 'meeting_attendant_delete',
            ],
            [
                'id'    => 144,
                'title' => 'meeting_attendant_access',
            ],
            [
                'id'    => 145,
                'title' => 'self_interested_user_create',
            ],
            [
                'id'    => 146,
                'title' => 'self_interested_user_edit',
            ],
            [
                'id'    => 147,
                'title' => 'self_interested_user_show',
            ],
            [
                'id'    => 148,
                'title' => 'self_interested_user_delete',
            ],
            [
                'id'    => 149,
                'title' => 'self_interested_user_access',
            ],
            [
                'id'    => 150,
                'title' => 'resources_audit_create',
            ],
            [
                'id'    => 151,
                'title' => 'resources_audit_edit',
            ],
            [
                'id'    => 152,
                'title' => 'resources_audit_show',
            ],
            [
                'id'    => 153,
                'title' => 'resources_audit_delete',
            ],
            [
                'id'    => 154,
                'title' => 'resources_audit_access',
            ],
            [
                'id'    => 155,
                'title' => 'report_access',
            ],
            [
                'id'    => 156,
                'title' => 'educational_bg_report_create',
            ],
            [
                'id'    => 157,
                'title' => 'educational_bg_report_edit',
            ],
            [
                'id'    => 158,
                'title' => 'educational_bg_report_show',
            ],
            [
                'id'    => 159,
                'title' => 'educational_bg_report_delete',
            ],
            [
                'id'    => 160,
                'title' => 'educational_bg_report_access',
            ],
            [
                'id'    => 161,
                'title' => 'whatsapp_word_create',
            ],
            [
                'id'    => 162,
                'title' => 'whatsapp_word_edit',
            ],
            [
                'id'    => 163,
                'title' => 'whatsapp_word_show',
            ],
            [
                'id'    => 164,
                'title' => 'whatsapp_word_delete',
            ],
            [
                'id'    => 165,
                'title' => 'whatsapp_word_access',
            ],
            [
                'id'    => 166,
                'title' => 'profile_create',
            ],
            [
                'id'    => 167,
                'title' => 'profile_edit',
            ],
            [
                'id'    => 168,
                'title' => 'profile_show',
            ],
            [
                'id'    => 169,
                'title' => 'profile_delete',
            ],
            [
                'id'    => 170,
                'title' => 'profile_access',
            ],
            [
                'id'    => 171,
                'title' => 'advertisement_access',
            ],
            [
                'id'    => 172,
                'title' => 'banner_create',
            ],
            [
                'id'    => 173,
                'title' => 'banner_edit',
            ],
            [
                'id'    => 174,
                'title' => 'banner_show',
            ],
            [
                'id'    => 175,
                'title' => 'banner_delete',
            ],
            [
                'id'    => 176,
                'title' => 'banner_access',
            ],
            [
                'id'    => 177,
                'title' => 'user_fav_resource_create',
            ],
            [
                'id'    => 178,
                'title' => 'user_fav_resource_edit',
            ],
            [
                'id'    => 179,
                'title' => 'user_fav_resource_show',
            ],
            [
                'id'    => 180,
                'title' => 'user_fav_resource_delete',
            ],
            [
                'id'    => 181,
                'title' => 'user_fav_resource_access',
            ],
            [
                'id'    => 182,
                'title' => 'search_create',
            ],
            [
                'id'    => 183,
                'title' => 'search_edit',
            ],
            [
                'id'    => 184,
                'title' => 'search_show',
            ],
            [
                'id'    => 185,
                'title' => 'search_delete',
            ],
            [
                'id'    => 186,
                'title' => 'search_access',
            ],
            [
                'id'    => 187,
                'title' => 'close_image_create',
            ],
            [
                'id'    => 188,
                'title' => 'close_image_edit',
            ],
            [
                'id'    => 189,
                'title' => 'close_image_show',
            ],
            [
                'id'    => 190,
                'title' => 'close_image_delete',
            ],
            [
                'id'    => 191,
                'title' => 'close_image_access',
            ],
            [
                'id'    => 192,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
