<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    // Colonnes qui peuvent être remplies en masse
    protected $fillable = [
    'user_id',
    'categorie_id',
    'titre',
    'description',
    'prix',
    'ville',
    'region',
    'etat',
    'status',
    'image',
    'galerie',
    ];


    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    public function messages()
    {
    return $this->hasMany(Message::class);
    }




}
