<?php

namespace App\Traits;

trait RoleChecks
{
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isPartner()
    {
        return $this->hasRole('partner');
    }

    public function isStaff()
    {
        return $this->hasRole('staff');
    }

    public function isRegularUser()
    {
        return $this->hasRole('user');
    }

    public function isAdminOrSuperAdmin()
    {
        return $this->hasRole(['super-admin', 'admin']);
    }

    public function isManagement()
    {
        return $this->hasRole(['super-admin', 'admin', 'partner']);
    }

    public function canVerify()
    {
        return $this->hasRole(['super-admin', 'admin', 'staff']);
    }
}