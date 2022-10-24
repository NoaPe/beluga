<?php

// List of all permissions
return [
    /**
     * Permission for super user
     */
    'super' => [
        /**
         * Beluga schema administration
         */
        'beluga_administration' => [
            'beluga_table_administration' => [
                'beluga_table_create',
                'beluga_table_update',
                'beluga_table_delete',
                'beluga_table_view',
            ],

            'beluga_group_administration' => [
                'beluga_group_create',
                'beluga_group_update',
                'beluga_group_delete',
                'beluga_group_view',
            ],

            'beluga_data_administration' => [
                'beluga_data_create',
                'beluga_data_update',
                'beluga_data_delete',
                'beluga_data_view',
            ],
        ],

        /**
         * Permission administration
         */
        'permission_administration' => [
            'permission_create',
            'permission_update',
            'permission_delete',
            'permission_view',
        ],
    ],
];
