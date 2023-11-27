<?php

return [
    'data_rows'  => [
        'author'           => '作成者',
        'personal_picture'           => 'アバター',
        'body'             => '本文',
        'category'         => 'カテゴリー',
        'created_at'       => '作成日時',
        'display_name'     => '表示名',
        'email'            => 'Email',
        'excerpt'          => '抜粋',
        'featured'         => '注目',
        'id'               => 'ID',
        'meta_description' => 'メタ 説明',
        'meta_keywords'    => 'メタ キーワード',
        'name'             => '名前',
        'order'            => '並び順',
        'page_image'       => 'ページイメージ',
        'parent'           => '親',
        'password'         => 'パスワード',
        'post_image'       => '投稿イメージ',
        'remember_token'   => 'トークン記憶',
        'role'             => 'ロール',
        'seo_title'        => 'SEOタイトル',
        'slug'             => 'スラッグ',
        'status'           => 'ステータス',
        'title'            => 'タイトル',
        'updated_at'       => '更新日時',
    ],
    'data_types' => [
        'category' => [
            'singular' => 'Category',
            'plural'   => 'Categories',
        ],
        'menu'     => [
            'singular' => 'Menu',
            'plural'   => 'Menus',
        ],
        'page'     => [
            'singular' => 'Page',
            'plural'   => 'Pages',
        ],
        'post'     => [
            'singular' => 'Post',
            'plural'   => 'Posts',
        ],
        'role'     => [
            'singular' => 'Role',
            'plural'   => 'Roles',
        ],
        'user'     => [
            'singular' => 'User',
            'plural'   => 'Users',
        ],
    ],
    'menu_items' => [
        'bread'        => 'BREAD',
        'categories'   => 'Categories',
        'compass'      => 'Compass',
        'dashboard'    => 'Dashboard',
        'database'     => 'Database',
        'media'        => 'Media',
        'menu_builder' => 'Menu Builder',
        'pages'        => 'Pages',
        'posts'        => 'Posts',
        'roles'        => 'Roles',
        'settings'     => 'Settings',
        'tools'        => 'Tools',
        'users'        => 'Users',
    ],
    'roles'      => [
        'admin' => '管理者',
        'user'  => '一般ユーザー',
    ],
    'settings'   => [
        'admin' => [
            'background_image'           => '管理者 背景イメージ',
            'description'                => '管理者 説明',
            'description_value'          => 'Voyagerへようこそ. The Missing Admin for Laravel',
            'google_analytics_client_id' => 'Googleアナリティクス クライアントID (管理ダッシュボード用)',
            'icon_image'                 => '管理者 アイコンイメージ',
            'loader'                     => '管理者 ローダー',
            'title'                      => '管理者 タイトル',
        ],
        'site'  => [
            'description'                  => 'サイト説明',
            'google_analytics_tracking_id' => 'Googleアナリティクス トラッキングID',
            'logo'                         => 'サイト ロゴ',
            'title'                        => 'サイト タイトル',
        ],
    ],
];
