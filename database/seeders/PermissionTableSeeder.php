<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'الفواتير',
            'قائمة الفواتير',
            'معلومات الفاتورة',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
            'أرشفة الفواتير',
            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',
            'الاعدادات',
            'المنتجات',
            'الاقسام',
    
    
            'اضافة فاتورة',
            'حذف الفاتورة',
            'تعديل الفاتورة',
            'تصدير EXCEL',
            'تغير حالة الدفع',
            'ارشفة الفاتورة',
            'طباعة الفاتورة',
            'اضافة مرفق',
            'حذف المرفق',
            'عرض المرفق',
            'تحميل المرفق',


            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
    
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
    
            'عرض مستخدم',
            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',
    
            'عرض الصلاحية',
            'اضافة صلاحية',
            'تعديل الصلاحية',
            'حذف الصلاحية',
           
            'الاشعارات',
    
             ];
    
             foreach ($permissions as $permission) {
                  Permission::create(['name' => $permission]);
             }
       }
}
