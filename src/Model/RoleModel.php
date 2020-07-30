<?php 
namespace App\Model;

class RoleModel 
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_DEVELOPER = 'ROLE_DEVELOPER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_FACULTY = 'ROLE_FACULTY';
    const ROLE_ADMINISTRATOR = 'ROLE_ADMINISTRATOR';

    const ACTION_ALL_PERMISSIONS = [
        'CAN_SHOW',
        'CAN_EDIT',
        'CAN_DELETE',
        'CAN_NEW',
        'CAN_IMPORT'
    ];

    const PERMISSION_FOR_ROLE_ADMIN = [
        'CAN_SHOW',
        'CAN_EDIT',
        'CAN_NEW'
    ];

    const PERMISSION_FOR_ROLE_USER = [
        'CAN_SHOW',
    ];
}