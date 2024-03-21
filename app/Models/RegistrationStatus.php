<?php
namespace App\Models;

enum RegistrationStatus: string
{
    case Registered = 'Đã đăng ký';
    case CheckedIn = 'Đã điểm danh';
    case Shot = 'Đã tiêm';
    case Canceled = 'Đã hủy';
}