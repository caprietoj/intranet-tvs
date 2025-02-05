<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentRequestCreated;

class DocumentRequest extends Model
{
    protected $fillable = ['user_id', 'document_id', 'description', 'status'];

    protected static function booted()
    {
        static::created(function($documentRequest) {
            // Send email to support address
            Mail::to('recursoshumanos@tvs.edu.co')->send(new DocumentRequestCreated($documentRequest));
            // Send email to the user if email provided
            if ($documentRequest->user && $documentRequest->user->email) {
                Mail::to($documentRequest->user->email)->send(new DocumentRequestCreated($documentRequest));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}