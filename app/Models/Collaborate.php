<?php

namespace App\Models;

use App\Models\CollaborationRole;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Collaborate extends MorphPivot
{
    protected $table = 'collaboratables';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'collaboration_roles'
    ];

    public function getCollaborationRolesAttribute()
    {
        $collaborations = self::whereCollaboratableId($this->collaboratable_id)
            ->whereCollaborateId($this->collaborate_id)
            ->whereCollaboratableType($this->collaboratable_type)
            ->get();

        $collaborationRoles = [];

        foreach($collaborations as $collaboration) {
            $collaborationRoles[] = $collaboration->role->title;
        }

        return $collaborationRoles;
    }

    public function role()
    {
        return $this->belongsTo(CollaborationRole::class, 'collaboration_role_id', 'id');
    }
}
