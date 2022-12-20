<?php

namespace SeinOxygen\AuditViewer\Contracts;

interface AuditViewContract
{
    public function setModel();

    public function audit($id);
}