<?php

namespace Database\Seeders;

use Dcat\Admin\Models;
use Illuminate\Database\Seeder;
use DB;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Models\Menu::truncate();
        Models\Menu::insert(
            [
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "feather icon-bar-chart-2",
                    "id" => 1,
                    "order" => 1,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "Index",
                    "updated_at" => NULL,
                    "uri" => "/"
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "feather icon-settings",
                    "id" => 2,
                    "order" => 2,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "Admin",
                    "updated_at" => NULL,
                    "uri" => ""
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "",
                    "id" => 3,
                    "order" => 3,
                    "parent_id" => 2,
                    "show" => 1,
                    "title" => "Users",
                    "updated_at" => NULL,
                    "uri" => "auth/users"
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "",
                    "id" => 4,
                    "order" => 4,
                    "parent_id" => 2,
                    "show" => 1,
                    "title" => "Roles",
                    "updated_at" => NULL,
                    "uri" => "auth/roles"
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "",
                    "id" => 5,
                    "order" => 5,
                    "parent_id" => 2,
                    "show" => 1,
                    "title" => "Permission",
                    "updated_at" => NULL,
                    "uri" => "auth/permissions"
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "",
                    "id" => 6,
                    "order" => 6,
                    "parent_id" => 2,
                    "show" => 1,
                    "title" => "Menu",
                    "updated_at" => NULL,
                    "uri" => "auth/menu"
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "extension" => "",
                    "icon" => "",
                    "id" => 7,
                    "order" => 7,
                    "parent_id" => 2,
                    "show" => 1,
                    "title" => "Extensions",
                    "updated_at" => NULL,
                    "uri" => "auth/extensions"
                ],
                [
                    "created_at" => "2021-09-08 14:55:51",
                    "extension" => "",
                    "icon" => "fa-user-circle",
                    "id" => 8,
                    "order" => 8,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "Users",
                    "updated_at" => "2021-09-08 14:55:51",
                    "uri" => "/user"
                ],
                [
                    "created_at" => "2021-09-08 14:58:54",
                    "extension" => "",
                    "icon" => "fa-money",
                    "id" => 9,
                    "order" => 11,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "Financial Management",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => NULL
                ],
                [
                    "created_at" => "2021-09-08 15:02:06",
                    "extension" => "",
                    "icon" => "fa-shopping-cart",
                    "id" => 10,
                    "order" => 12,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "Product Management",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => NULL
                ],
                [
                    "created_at" => "2021-09-08 15:03:30",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 11,
                    "order" => 13,
                    "parent_id" => 10,
                    "show" => 1,
                    "title" => "Product",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "/products"
                ],
                [
                    "created_at" => "2021-09-08 15:04:09",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 12,
                    "order" => 14,
                    "parent_id" => 10,
                    "show" => 1,
                    "title" => "Category",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "/category"
                ],
                [
                    "created_at" => "2021-09-08 15:19:29",
                    "extension" => "",
                    "icon" => "fa-gears",
                    "id" => 13,
                    "order" => 16,
                    "parent_id" => 0,
                    "show" => 1,
                    "title" => "System Configuration",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => NULL
                ],
                [
                    "created_at" => "2021-09-08 15:21:36",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 14,
                    "order" => 17,
                    "parent_id" => 13,
                    "show" => 1,
                    "title" => "Theme Configuration",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "theme-setup"
                ],
                [
                    "created_at" => "2021-09-09 16:58:36",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 15,
                    "order" => 18,
                    "parent_id" => 13,
                    "show" => 1,
                    "title" => "Setup",
                    "updated_at" => "2021-09-09 17:02:29",
                    "uri" => "/setup"
                ],
                [
                    "created_at" => "2021-09-09 16:59:42",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 16,
                    "order" => 9,
                    "parent_id" => 8,
                    "show" => 1,
                    "title" => "Tickets",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "/tickets"
                ],
                [
                    "created_at" => "2021-09-09 17:00:22",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 17,
                    "order" => 15,
                    "parent_id" => 10,
                    "show" => 1,
                    "title" => "Billing",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "/billing"
                ],
                [
                    "created_at" => "2021-09-09 17:00:55",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 18,
                    "order" => 10,
                    "parent_id" => 8,
                    "show" => 1,
                    "title" => "Users",
                    "updated_at" => "2021-09-09 17:02:28",
                    "uri" => "/user"
                ],
                [
                    "created_at" => "2021-11-07 22:24:45",
                    "extension" => "",
                    "icon" => NULL,
                    "id" => 19,
                    "order" => 19,
                    "parent_id" => 13,
                    "show" => 1,
                    "title" => "HSTACK Configuration",
                    "updated_at" => "2021-11-07 22:24:45",
                    "uri" => "/setup-hstack"
                ]
            ]
        );

        Models\Permission::truncate();
        Models\Permission::insert(
            [
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "",
                    "id" => 1,
                    "name" => "Auth management",
                    "order" => 1,
                    "parent_id" => 0,
                    "slug" => "auth-management",
                    "updated_at" => NULL
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "/auth/users*",
                    "id" => 2,
                    "name" => "Users",
                    "order" => 2,
                    "parent_id" => 1,
                    "slug" => "users",
                    "updated_at" => NULL
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "/auth/roles*",
                    "id" => 3,
                    "name" => "Roles",
                    "order" => 3,
                    "parent_id" => 1,
                    "slug" => "roles",
                    "updated_at" => NULL
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "/auth/permissions*",
                    "id" => 4,
                    "name" => "Permissions",
                    "order" => 4,
                    "parent_id" => 1,
                    "slug" => "permissions",
                    "updated_at" => NULL
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "/auth/menu*",
                    "id" => 5,
                    "name" => "Menu",
                    "order" => 5,
                    "parent_id" => 1,
                    "slug" => "menu",
                    "updated_at" => NULL
                ],
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "http_method" => "",
                    "http_path" => "/auth/extensions*",
                    "id" => 6,
                    "name" => "Extension",
                    "order" => 6,
                    "parent_id" => 1,
                    "slug" => "extension",
                    "updated_at" => NULL
                ]
            ]
        );

        Models\Role::truncate();
        Models\Role::insert(
            [
                [
                    "created_at" => "2021-09-08 14:42:07",
                    "id" => 1,
                    "name" => "Administrator",
                    "slug" => "administrator",
                    "updated_at" => "2021-09-08 14:42:07"
                ]
            ]
        );

        Models\Setting::truncate();
		Models\Setting::insert(
			[

            ]
		);

		Models\Extension::truncate();
		Models\Extension::insert(
			[

            ]
		);

		Models\ExtensionHistory::truncate();
		Models\ExtensionHistory::insert(
			[

            ]
		);

        // pivot tables
        DB::table('admin_permission_menu')->truncate();
		DB::table('admin_permission_menu')->insert(
			[

            ]
		);

        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [

            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [

            ]
        );

        // finish
    }
}
