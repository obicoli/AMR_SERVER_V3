<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.company',
        //     'description' => 'Administration',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.company',
        //     'description' => 'Administration',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.company',
        //     'description' => 'Administration', //----------
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.company',
        //     'description' => 'Administration',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);

        // //------------
        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.finance',
        //     'description' => 'Administration',
        //     'descriptions' => 'Finance',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.finance',
        //     'description' => 'Administration',
        //     'descriptions' => 'Finance',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.finance',
        //     'description' => 'Administration',
        //     'descriptions' => 'Finance',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.finance',
        //     'description' => 'Administration',
        //     'descriptions' => 'Finance',
        //     'model'       => 'Permission',
        // ]);
        // //
        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.tax',
        //     'description' => 'Administration',
        //     'descriptions' => 'Tax',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.tax',
        //     'description' => 'Administration',
        //     'descriptions' => 'Tax',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.tax',
        //     'description' => 'Administration',
        //     'descriptions' => 'Tax',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.tax',
        //     'description' => 'Administration',
        //     'descriptions' => 'Tax',
        //     'model'       => 'Permission',
        // ]);

        //
        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.company',
        //     'description' => 'Administrative',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.company',
        //     'description' => 'Administrative',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.company',
        //     'description' => 'Administrative',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.company',
        //     'description' => 'Administrative',
        //     'descriptions' => 'Company',
        //     'model'       => 'Permission',
        // ]);


        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.department',
            'description' => 'Department',
            'descriptions' => 'Department',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.department',
            'description' => 'Department',
            'descriptions' => 'Department',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.department',
            'description' => 'Department',
            'descriptions' => 'Department',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.department',
            'description' => 'Department',
            'descriptions' => 'Department',
            'model'       => 'Permission',
        ]);
        
        

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.email',
            'description' => 'Treatment Communication',
            'descriptions' => 'Email',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.email',
            'description' => 'Treatment Communication',
            'descriptions' => 'Email',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.email',
            'description' => 'Treatment Communication',
            'descriptions' => 'Email',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.email',
            'description' => 'Treatment Communication',
            'descriptions' => 'Email',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.sms.report',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.sms.report',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.sms.report',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.sms.report',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Report',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.sms.template',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Template',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.sms.template',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Template',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.sms.template',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Template',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.sms.template',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS Template',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.sms',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.sms',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.sms',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.sms',
            'description' => 'Treatment Communication',
            'descriptions' => 'SMS',
            'model'       => 'Permission',
        ]);

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.inquiry',
            'description' => 'Inquiry',
            'descriptions' => 'Inquiry',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.inquiry',
            'description' => 'Inquiry',
            'descriptions' => 'Inquiry',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.inquiry',
            'description' => 'Inquiry',
            'descriptions' => 'Inquiry',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.inquiry',
            'description' => 'Inquiry',
            'descriptions' => 'Inquiry',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.ha.ir',
            'description' => 'Hospital Activity',
            'descriptions' => 'Investigation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.ha.ir',
            'description' => 'Hospital Activity',
            'descriptions' => 'Investigation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.ha.ir',
            'description' => 'Hospital Activity',
            'descriptions' => 'Investigation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.ha.ir',
            'description' => 'Hospital Activity',
            'descriptions' => 'Investigation Report',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.ha.or',
            'description' => 'Hospital Activity',
            'descriptions' => 'Operation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.ha.or',
            'description' => 'Hospital Activity',
            'descriptions' => 'Operation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.ha.or',
            'description' => 'Hospital Activity',
            'descriptions' => 'Operation Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.ha.or',
            'description' => 'Hospital Activity',
            'descriptions' => 'Operation Report',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.ha.dr',
            'description' => 'Hospital Activity',
            'descriptions' => 'Death Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.ha.dr',
            'description' => 'Hospital Activity',
            'descriptions' => 'Death Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.ha.dr',
            'description' => 'Hospital Activity',
            'descriptions' => 'Death Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.ha.dr',
            'description' => 'Hospital Activity',
            'descriptions' => 'Death Report',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.ha.br',
            'description' => 'Hospital Activity',
            'descriptions' => 'Birth Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.ha.br',
            'description' => 'Hospital Activity',
            'descriptions' => 'Birth Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.ha.br',
            'description' => 'Hospital Activity',
            'descriptions' => 'Birth Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.ha.br',
            'description' => 'Hospital Activity',
            'descriptions' => 'Birth Report',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.cm.patient',
            'description' => 'Case Manager',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.cm.patient',
            'description' => 'Case Manager',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.cm.patient',
            'description' => 'Case Manager',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.cm.patient',
            'description' => 'Case Manager',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.noticeboard',
            'description' => 'Noticeboard',
            'descriptions' => 'Noticeboard',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.noticeboard',
            'description' => 'Noticeboard',
            'descriptions' => 'Noticeboard',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.noticeboard',
            'description' => 'Noticeboard',
            'descriptions' => 'Noticeboard',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.noticeboard',
            'description' => 'Noticeboard',
            'descriptions' => 'Noticeboard',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.bed.report',
            'description' => 'Bed Manager',
            'descriptions' => 'Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.bed.report',
            'description' => 'Bed Manager',
            'descriptions' => 'Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.bed.report',
            'description' => 'Bed Manager',
            'descriptions' => 'Report',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.bed.report',
            'description' => 'Bed Manager',
            'descriptions' => 'Report',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.bed',
            'description' => 'Bed Manager',
            'descriptions' => 'Bed',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.bed',
            'description' => 'Bed Manager',
            'descriptions' => 'Bed',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.bed',
            'description' => 'Bed Manager',
            'descriptions' => 'Bed',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.bed',
            'description' => 'Bed Manager',
            'descriptions' => 'Bed',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'assign.bed',
            'description' => 'Bed Manager',
            'descriptions' => 'Bed',
            'model'       => 'Permission',
        ]);

        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.employee',
        //     'description' => 'Human Resource',
        //     'descriptions' => 'Employee',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.employee',
        //     'description' => 'Human Resource',
        //     'descriptions' => 'Employee',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.employee',
        //     'description' => 'Human Resource',
        //     'descriptions' => 'Employee',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.employee',
        //     'description' => 'Human Resource',
        //     'descriptions' => 'Employee',
        //     'model'       => 'Permission',
        // ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.employee',
            'description' => 'Human Resource',
            'descriptions' => 'Employee',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.employee',
            'description' => 'Human Resource',
            'descriptions' => 'Employee',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.employee',
            'description' => 'Human Resource',
            'descriptions' => 'Employee',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.employee',
            'description' => 'Human Resource',
            'descriptions' => 'Employee',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.billing.bill',
            'description' => 'Billing',
            'descriptions' => 'Bill',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.billing.bill',
            'description' => 'Billing',
            'descriptions' => 'Bill',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.billing.bill',
            'description' => 'Billing',
            'descriptions' => 'Bill',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.billing.bill',
            'description' => 'Billing',
            'descriptions' => 'Bill',
            'model'       => 'Permission',
        ]);

        // Permission::create([
        //     'name'        => 'Create',
        //     'slug'        => 'create.billing.package',
        //     'description' => 'Billing',
        //     'descriptions' => 'Package',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Edit',
        //     'slug'        => 'edit.billing.package',
        //     'description' => 'Billing',
        //     'descriptions' => 'Package',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'View',
        //     'slug'        => 'view.billing.package',
        //     'description' => 'Billing',
        //     'descriptions' => 'Package',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Delete',
        //     'slug'        => 'delete.billing.package',
        //     'description' => 'Billing',
        //     'descriptions' => 'Package',
        //     'model'       => 'Permission',
        // ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.billing.advance.payment',
            'description' => 'Billing',
            'descriptions' => 'Advance Payment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.billing.advance.payment',
            'description' => 'Billing',
            'descriptions' => 'Advance Payment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.billing.advance.payment',
            'description' => 'Billing',
            'descriptions' => 'Advance Payment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.billing.advance.payment',
            'description' => 'Billing',
            'descriptions' => 'Advance Payment',
            'model'       => 'Permission',
        ]);
        //

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.billing.admission',
            'description' => 'Billing',
            'descriptions' => 'Patient Admission',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.billing.admission',
            'description' => 'Billing',
            'descriptions' => 'Patient Admission',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.billing.admission',
            'description' => 'Billing',
            'descriptions' => 'Patient Admission',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.billing.admission',
            'description' => 'Billing',
            'descriptions' => 'Patient Admission',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.billing.package',
            'description' => 'Billing',
            'descriptions' => 'Package',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.billing.package',
            'description' => 'Billing',
            'descriptions' => 'Package',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.billing.package',
            'description' => 'Billing',
            'descriptions' => 'Package',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.billing.package',
            'description' => 'Billing',
            'descriptions' => 'Package',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.billing.service',
            'description' => 'Billing',
            'descriptions' => 'Service',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.billing.service',
            'description' => 'Billing',
            'descriptions' => 'Service',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.billing.service',
            'description' => 'Billing',
            'descriptions' => 'Service',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.billing.service',
            'description' => 'Billing',
            'descriptions' => 'Service',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.insurance.limit',
            'description' => 'Insurance',
            'descriptions' => 'Limit Approval',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.insurance.limit',
            'description' => 'Insurance',
            'descriptions' => 'Limit Approval',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.insurance.limit',
            'description' => 'Insurance',
            'descriptions' => 'Limit Approval',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.insurance.limit',
            'description' => 'Insurance',
            'descriptions' => 'Limit Approval',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.insurance',
            'description' => 'Insurance',
            'descriptions' => 'Insurance',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.insurance',
            'description' => 'Insurance',
            'descriptions' => 'Insurance',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.insurance',
            'description' => 'Insurance',
            'descriptions' => 'Insurance',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.insurance',
            'description' => 'Insurance',
            'descriptions' => 'Insurance',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.doctor',
            'description' => 'Doctor',
            'descriptions' => 'doctor',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.doctor',
            'description' => 'Doctor',
            'descriptions' => 'doctor',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.doctor',
            'description' => 'Doctor',
            'descriptions' => 'doctor',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.doctor',
            'description' => 'Doctor',
            'descriptions' => 'doctor',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.patient.document',
            'description' => 'Patient',
            'descriptions' => 'Document',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.patient.document',
            'description' => 'Patient',
            'descriptions' => 'Document',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.patient.document',
            'description' => 'Patient',
            'descriptions' => 'Document',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.patient.document',
            'description' => 'Patient',
            'descriptions' => 'Document',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.patient',
            'description' => 'Patient',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.patient',
            'description' => 'Patient',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.patient',
            'description' => 'Patient',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.patient',
            'description' => 'Patient',
            'descriptions' => 'Patient',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.teleconsult',
            'description' => 'Calendar',
            'descriptions' => 'Teleconsult',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.teleconsult',
            'description' => 'Calendar',
            'descriptions' => 'Teleconsult',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.teleconsult',
            'description' => 'Calendar',
            'descriptions' => 'Teleconsult',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.teleconsult',
            'description' => 'Calendar',
            'descriptions' => 'Teleconsult',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.appointment',
            'description' => 'Calendar',
            'descriptions' => 'Appointment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.appointment',
            'description' => 'Calendar',
            'descriptions' => 'Appointment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.appointment',
            'description' => 'Calendar',
            'descriptions' => 'Appointment',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.appointment',
            'description' => 'Calendar',
            'descriptions' => 'Appointment',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.schedule',
            'description' => 'Calendar',
            'descriptions' => 'Schedule',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.schedule',
            'description' => 'Calendar',
            'descriptions' => 'Schedule',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.schedule',
            'description' => 'Calendar',
            'descriptions' => 'Schedule',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.schedule',
            'description' => 'Calendar',
            'descriptions' => 'Schedule',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.vital.signs',
            'description' => 'Medical Records',
            'descriptions' => 'Vital Signs',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.vital.signs',
            'description' => 'Medical Records',
            'descriptions' => 'Vital Signs',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.vital.signs',
            'description' => 'Medical Records',
            'descriptions' => 'Vital Signs',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.vital.signs',
            'description' => 'Medical Records',
            'descriptions' => 'Vital Signs',
            'model'       => 'Permission',
        ]);

        //Inventory Permissions
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.product.services',
            'description' => 'Inventory',
            'descriptions' => 'Product & Services',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.product.services',
            'description' => 'Inventory',
            'descriptions' => 'Product & Services',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.product.services',
            'description' => 'Inventory',
            'descriptions' => 'Product & Services',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.product.services',
            'description' => 'Inventory',
            'descriptions' => 'Product & Services',
            'model'       => 'Permission',
        ]);
        //-------------------------------------
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.warehouse',
            'description' => 'Inventory',
            'descriptions' => 'Warehouse',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.warehouse',
            'description' => 'Inventory',
            'descriptions' => 'Warehouse',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.warehouse',
            'description' => 'Inventory',
            'descriptions' => 'Warehouse',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.warehouse',
            'description' => 'Inventory',
            'descriptions' => 'Warehouse',
            'model'       => 'Permission',
        ]);
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.vendor',
//            'description' => 'Inventory',
//            'descriptions' => 'Supplier',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.vendor',
//            'description' => 'Inventory',
//            'descriptions' => 'Supplier',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.vendor',
//            'description' => 'Inventory',
//            'descriptions' => 'Supplier',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.vendor',
//            'description' => 'Inventory',
//            'descriptions' => 'Supplier',
//            'model'       => 'Permission',
//        ]);
//        //Inventory Supply
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Print',
//            'slug'        => 'print.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Pick',
//            'slug'        => 'pick.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Pack',
//            'slug'        => 'pack.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Ship',
//            'slug'        => 'ship.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Receive',
//            'slug'        => 'receive.inv.supply',
//            'description' => 'Inventory',
//            'descriptions' => 'Supply',
//            'model'       => 'Permission',
//        ]);
//        //
//
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.customer',
//            'description' => 'Inventory',
//            'descriptions' => 'Customer',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.customer',
//            'description' => 'Inventory',
//            'descriptions' => 'Customer',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.customer',
//            'description' => 'Inventory',
//            'descriptions' => 'Customer',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.customer',
//            'description' => 'Inventory',
//            'descriptions' => 'Customer',
//            'model'       => 'Permission',
//        ]);
//        //
//
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.sales',
//            'description' => 'Inventory',
//            'descriptions' => 'Sales',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.sales',
//            'description' => 'Inventory',
//            'descriptions' => 'Sales',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.sales',
//            'description' => 'Inventory',
//            'descriptions' => 'Sales',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.sales',
//            'description' => 'Inventory',
//            'descriptions' => 'Sales',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.product',
//            'description' => 'Inventory',
//            'descriptions' => 'Product',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.product',
//            'description' => 'Inventory',
//            'descriptions' => 'Product',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.product',
//            'description' => 'Inventory',
//            'descriptions' => 'Product',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.product',
//            'description' => 'Inventory',
//            'descriptions' => 'Product',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Approve',
//            'slug'        => 'approve.product',
//            'description' => 'Inventory',
//            'descriptions' => 'Product',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.stock',
//            'description' => 'Inventory',
//            'descriptions' => 'Stock',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.stock',
//            'description' => 'Inventory',
//            'descriptions' => 'Stock',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.stock',
//            'description' => 'Inventory',
//            'descriptions' => 'Stock',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.stock',
//            'description' => 'Inventory',
//            'descriptions' => 'Stock',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Approve',
//            'slug'        => 'approve.stock',
//            'description' => 'Inventory',
//            'descriptions' => 'Stock',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.inv.report',
//            'description' => 'Inventory',
//            'descriptions' => 'Report',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.inv.report',
//            'description' => 'Inventory',
//            'descriptions' => 'Report',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Print',
//            'slug'        => 'print.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Pick',
//            'slug'        => 'pick.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Pack',
//            'slug'        => 'pack.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Ship',
//            'slug'        => 'ship.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Receive',
//            'slug'        => 'receive.request',
//            'description' => 'Inventory',
//            'descriptions' => 'Requistion',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.store',
//            'description' => 'Inventory',
//            'descriptions' => 'Stores',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.store',
//            'description' => 'Inventory',
//            'descriptions' => 'Stores',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.store',
//            'description' => 'Inventory',
//            'descriptions' => 'Stores',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.store',
//            'description' => 'Inventory',
//            'descriptions' => 'Stores',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Approve',
//            'slug'        => 'approve.store',
//            'description' => 'Inventory',
//            'descriptions' => 'Stores',
//            'model'       => 'Permission',
//        ]);
//        //
//        Permission::create([
//            'name'        => 'Create',
//            'slug'        => 'create.purchase',
//            'description' => 'Inventory',
//            'descriptions' => 'Purchase',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Edit',
//            'slug'        => 'edit.purchase',
//            'description' => 'Inventory',
//            'descriptions' => 'Purchase',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'View',
//            'slug'        => 'view.purchase',
//            'description' => 'Inventory',
//            'descriptions' => 'Purchase',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Delete',
//            'slug'        => 'delete.purchase',
//            'description' => 'Inventory',
//            'descriptions' => 'Purchase',
//            'model'       => 'Permission',
//        ]);
//        Permission::create([
//            'name'        => 'Approve',
//            'slug'        => 'approve.purchase',
//            'description' => 'Inventory',
//            'descriptions' => 'Purchase',
//            'model'       => 'Permission',
//        ]);
        //===============================================Inventory Ends Here==============

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.invoice',
            'description' => 'Accounting',
            'descriptions' => 'Invoice',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.invoice',
            'description' => 'Accounting',
            'descriptions' => 'Invoice',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.invoice',
            'description' => 'Accounting',
            'descriptions' => 'Invoice',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.invoice',
            'description' => 'Accounting',
            'descriptions' => 'Invoice',
            'model'       => 'Permission',
        ]);
        //Payments
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.sp',
            'description' => 'Accounting',
            'descriptions' => 'Payments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.sp',
            'description' => 'Accounting',
            'descriptions' => 'Payments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.sp',
            'description' => 'Accounting',
            'descriptions' => 'Payments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.sp',
            'description' => 'Accounting',
            'descriptions' => 'Payments',
            'model'       => 'Permission',
        ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Driver',
        //     'slug'        => 'create.driver',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Driver',
        //     'slug'        => 'view.driver',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Driver',
        //     'slug'        => 'edit.driver',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Driver',
        //     'slug'        => 'delete.driver',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Vehicle',
        //     'slug'        => 'create.vehicle',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Vehicle',
        //     'slug'        => 'view.vehicle',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Vehicle',
        //     'slug'        => 'edit.vehicle',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Vehicle',
        //     'slug'        => 'delete.vehicle',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Salesman',
        //     'slug'        => 'create.salesman',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Salesman',
        //     'slug'        => 'view.salesman',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Salesman',
        //     'slug'        => 'edit.salesman',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Salesman',
        //     'slug'        => 'delete.salesman',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Supply',
        //     'model'       => 'Permission',
        // ]);

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.orders',
            'description' => 'Accounting',
            'descriptions' => 'Order',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.orders',
            'description' => 'Accounting',
            'descriptions' => 'Order',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.orders',
            'description' => 'Accounting',
            'descriptions' => 'Order',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => ' Delete',
            'slug'        => 'delete.orders',
            'description' => 'Accounting',
            'descriptions' => 'Order',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.expense',
            'description' => 'Accounting',
            'descriptions' => 'Expense',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.expense',
            'description' => 'Accounting',
            'descriptions' => 'Expense',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.expense',
            'description' => 'Accounting',
            'descriptions' => 'Expense',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.expense',
            'description' => 'Accounting',
            'descriptions' => 'Expense',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Approve',
            'slug'        => 'approve.expense',
            'description' => 'Accounting',
            'descriptions' => 'Expense',
            'model'       => 'Permission',
        ]);

        //Banks: Cheques
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.cheques',
            'description' => 'Accounting',
            'descriptions' => 'Cheques',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.cheques',
            'description' => 'Accounting',
            'descriptions' => 'Cheques',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.cheques',
            'description' => 'Accounting',
            'descriptions' => 'Cheques',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.cheques',
            'description' => 'Accounting',
            'descriptions' => 'Cheques',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Approve',
            'slug'        => 'approve.cheques',
            'description' => 'Accounting',
            'descriptions' => 'Cheques',
            'model'       => 'Permission',
        ]);
        //Banks: Banks
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.banks',
            'description' => 'Accounting',
            'descriptions' => 'Bank',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.banks',
            'description' => 'Accounting',
            'descriptions' => 'Bank',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.banks',
            'description' => 'Accounting',
            'descriptions' => 'Bank',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.banks',
            'description' => 'Accounting',
            'descriptions' => 'Bank',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Approve',
            'slug'        => 'approve.banks',
            'description' => 'Accounting',
            'descriptions' => 'Bank',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.banks.deposit',
            'description' => 'Accounting',
            'descriptions' => 'Bank Deposit',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.banks.deposit',
            'description' => 'Accounting',
            'descriptions' => 'Bank Deposit',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.banks.deposit',
            'description' => 'Accounting',
            'descriptions' => 'Bank Deposit',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.banks.deposit',
            'description' => 'Accounting',
            'descriptions' => 'Bank Deposit',
            'model'       => 'Permission',
        ]);
        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.banks.book',
            'description' => 'Accounting',
            'descriptions' => 'Bank Book',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.banks.book',
            'description' => 'Accounting',
            'descriptions' => 'Bank Book',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.banks.book',
            'description' => 'Accounting',
            'descriptions' => 'Bank Book',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.banks.book',
            'description' => 'Accounting',
            'descriptions' => 'Bank Book',
            'model'       => 'Permission',
        ]);
        //collection
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.banks.collections',
            'description' => 'Accounting',
            'descriptions' => 'Bank Collections',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.banks.collections',
            'description' => 'Accounting',
            'descriptions' => 'Bank Collections',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.banks.collections',
            'description' => 'Accounting',
            'descriptions' => 'Bank Collections',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.banks.collections',
            'description' => 'Accounting',
            'descriptions' => 'Bank Collections',
            'model'       => 'Permission',
        ]);
        /////////////////////////////////////////////////////////////////////////////
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.account',
            'description' => 'Accounting',
            'descriptions' => 'Accounts',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.account',
            'description' => 'Accounting',
            'descriptions' => 'Accounts',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.account',
            'description' => 'Accounting',
            'descriptions' => 'Accounts',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.account',
            'description' => 'Accounting',
            'descriptions' => 'Accounts',
            'model'       => 'Permission',
        ]);

                // Permission::create([
        //     'name'        => 'Can Create Account',
        //     'slug'        => 'create.account',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Account',
        //     'slug'        => 'view.account',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Account',
        //     'slug'        => 'edit.account',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Account',
        //     'slug'        => 'delete.account',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Create Opening Balance',
        //     'slug'        => 'create.ob',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Opening Balance',
        //     'slug'        => 'view.ob',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Opening Balance',
        //     'slug'        => 'edit.ob',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Opening Balance',
        //     'slug'        => 'delete.ob',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);

        // Permission::create([
        //     'name'        => 'Can Create Credit Vouchers',
        //     'slug'        => 'create.cv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Credit Vouchers',
        //     'slug'        => 'view.cv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Credit Vouchers',
        //     'slug'        => 'edit.cv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Account',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Credit Vouchers',
        //     'slug'        => 'delete.cv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Debit Vouchers',
        //     'slug'        => 'create.dv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Debit Vouchers',
        //     'slug'        => 'view.dv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Debit Vouchers',
        //     'slug'        => 'edit.dv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts', //--------------------------------------------------------------------------
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Debit Vouchers',
        //     'slug'        => 'delete.dv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Journal Vouchers',
        //     'slug'        => 'create.jv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Journal Vouchers',
        //     'slug'        => 'view.jv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Journal Vouchers',
        //     'slug'        => 'edit.jv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Journal Vouchers',
        //     'slug'        => 'delete.jv',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Account Holders',
        //     'slug'        => 'create.ah',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Account Holders',
        //     'slug'        => 'view.ah',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Account Holders',
        //     'slug'        => 'edit.ah',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Account Holders',
        //     'slug'        => 'delete.ah',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Accounts',
        //     'model'       => 'Permission',
        // ]);

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.gj',
            'description' => 'Accounting',
            'descriptions' => 'Statements',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.gj',
            'description' => 'Accounting',
            'descriptions' => 'Statements',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.gj',
            'description' => 'Accounting',
            'descriptions' => 'Statements',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.gj',
            'description' => 'Accounting',
            'descriptions' => 'Statements',
            'model'       => 'Permission',
        ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create General Ledger',
        //     'slug'        => 'create.gl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View General Ledger',
        //     'slug'        => 'view.gl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit General Ledger',
        //     'slug'        => 'edit.gl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete General Ledger',
        //     'slug'        => 'delete.gl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Trial Balance',
        //     'slug'        => 'create.tl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Trial Balance',
        //     'slug'        => 'view.tl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Trial Balance',
        //     'slug'        => 'edit.tl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Trial Balance',
        //     'slug'        => 'delete.tl',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Income Statement',
        //     'slug'        => 'create.is',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Income Statement',
        //     'slug'        => 'view.is',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Income Statement',
        //     'slug'        => 'edit.is',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Income Statement',
        //     'slug'        => 'delete.is',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Balance Sheet',
        //     'slug'        => 'create.bs',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Balance Sheet',
        //     'slug'        => 'view.bs',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Balance Sheet',
        //     'slug'        => 'edit.bs',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Balance Sheet',
        //     'slug'        => 'delete.bs',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);

        // //
        // Permission::create([
        //     'name'        => 'Can Create Bank Reconcile',
        //     'slug'        => 'create.br',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can View Bank Reconcile',
        //     'slug'        => 'view.br',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Edit Bank Reconcile',
        //     'slug'        => 'edit.br',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);
        // Permission::create([
        //     'name'        => 'Can Delete Bank Reconcile',
        //     'slug'        => 'delete.br',
        //     'description' => 'Inventory',
        //     'descriptions' => 'Statements',
        //     'model'       => 'Permission',
        // ]);

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.quotations',
            'description' => 'Accounting',
            'descriptions' => 'Estimates',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.quotations',
            'description' => 'Accounting',
            'descriptions' => 'Estimates',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.quotations',
            'description' => 'Accounting',
            'descriptions' => 'Estimates',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.quotations',
            'description' => 'Accounting',
            'descriptions' => 'Estimates',
            'model'       => 'Permission',
        ]);
        //
        /////////////////////////////////////////////////////////////////////////////////////


        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.region',
            'description' => 'Settings',
            'descriptions' => 'Region',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.region',
            'description' => 'Settings',
            'descriptions' => 'Region',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.region',
            'description' => 'Settings',
            'descriptions' => 'Region',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.region',
            'description' => 'Settings',
            'descriptions' => 'Region',
            'model'       => 'Permission',
        ]);

        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.town',
            'description' => 'Settings',
            'descriptions' => 'Town',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.town',
            'description' => 'Settings',
            'descriptions' => 'Town',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.town',
            'description' => 'Settings',
            'descriptions' => 'Town',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.town',
            'description' => 'Settings',
            'descriptions' => 'Town',
            'model'       => 'Permission',
        ]);

        //
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.reports',
            'description' => 'Reports',
            'descriptions' => 'Reports',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.reports',
            'description' => 'Reports',
            'descriptions' => 'Reports',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.reports',
            'description' => 'Reports',
            'descriptions' => 'Reports',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.reports',
            'description' => 'Reports',
            'descriptions' => 'Reports',
            'model'       => 'Permission',
        ]);

        //----------------------------------------------------------------------------
         Permission::create([
             'name'        => 'Create',
             'slug'        => 'create.company',
             'description' => 'Company',
             'descriptions' => 'Company',
             'model'       => 'Permission',
         ]);
         Permission::create([
             'name'        => 'Edit',
             'slug'        => 'edit.company',
             'description' => 'Company',
             'descriptions' => 'Company',
             'model'       => 'Permission',
         ]);
         Permission::create([
             'name'        => 'View',
             'slug'        => 'view.company',
             'description' => 'Company',
             'descriptions' => 'Company',
             'model'       => 'Permission',
         ]);
         Permission::create([
             'name'        => 'Delete',
             'slug'        => 'delete.company',
             'description' => 'Company',
             'descriptions' => 'Company',
             'model'       => 'Permission',
         ]);
         //
         Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.company.notes.attachment',
            'description' => 'Company',
            'descriptions' => 'Notes & Attachments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.company.notes.attachment',
            'description' => 'Company',
            'descriptions' => 'Notes & Attachments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.company.notes.attachment',
            'description' => 'Company',
            'descriptions' => 'Notes & Attachments',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.company.notes.attachment',
            'description' => 'Company',
            'descriptions' => 'Notes & Attachments',
            'model'       => 'Permission',
        ]);
        //Import Data
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.company.import.data',
            'description' => 'Company',
            'descriptions' => 'Import Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.company.import.data',
            'description' => 'Company',
            'descriptions' => 'Import Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.company.import.data',
            'description' => 'Company',
            'descriptions' => 'Import Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.company.import.data',
            'description' => 'Company',
            'descriptions' => 'Import Data',
            'model'       => 'Permission',
        ]);
        //Export Data
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.company.export.data',
            'description' => 'Company',
            'descriptions' => 'Export Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.company.export.data',
            'description' => 'Company',
            'descriptions' => 'Export Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.company.export.data',
            'description' => 'Company',
            'descriptions' => 'Export Data',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.company.export.data',
            'description' => 'Company',
            'descriptions' => 'Export Data',
            'model'       => 'Permission',
        ]);
        //Opening Data
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.company.opening.balance',
            'description' => 'Company',
            'descriptions' => 'Opening Balances',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.company.opening.balance',
            'description' => 'Company',
            'descriptions' => 'Opening Balances',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.company.opening.balance',
            'description' => 'Company',
            'descriptions' => 'Opening Balances',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.company.opening.balance',
            'description' => 'Company',
            'descriptions' => 'Opening Balances',
            'model'       => 'Permission',
        ]);
        //----------------------------------------------------------------------------

        //---------------------------------------------------------
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.role',
            'description' => 'Administration',
            'descriptions' => 'Role',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.role',
            'description' => 'Administration',
            'descriptions' => 'Role',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.role',
            'description' => 'Administration',
            'descriptions' => 'Role',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.role',
            'description' => 'Administration',
            'descriptions' => 'Role',
            'model'       => 'Permission',
        ]);
        //Adminstrative:  Users
        Permission::create([
            'name'        => 'Create',
            'slug'        => 'create.users',
            'description' => 'Administration',
            'descriptions' => 'User',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Edit',
            'slug'        => 'edit.users',
            'description' => 'Administration',
            'descriptions' => 'User',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'View',
            'slug'        => 'view.users',
            'description' => 'Administration',
            'descriptions' => 'User',
            'model'       => 'Permission',
        ]);
        Permission::create([
            'name'        => 'Delete',
            'slug'        => 'delete.users',
            'description' => 'Administration',
            'descriptions' => 'User',
            'model'       => 'Permission',
        ]);

    }
}
