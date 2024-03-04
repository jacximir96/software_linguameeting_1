<?php

namespace App\Src\Shared\Presenter;

class SidebarMenu
{
    public static function isOpenWithRouteIs(string $name, string $classIs, string $classNotIs): string
    {
        return request()->routeIs($name) ? $classIs : $classNotIs;
    }

    public static function isOpenCourses()
    {
        return request()->routeIs('get.admin.course.*');
    }

    public static function isOpenUniversity()
    {
        return request()->routeIs('get.admin.university.*');
    }

    public static function isOpenUniversityOption()
    {

        if (self::isOpenUniversity()) {

            if (! self::isOpenUniversityBookstore()) {
                return true;
            }
        }

        return false;
    }

    public static function isOpenUniversityBookstore()
    {
        return request()->routeIs('get.admin.university.bookstore*');
    }

    public static function isOpenInstructors()
    {
        return request()->routeIs('get.admin.instructor.*');
    }
}
