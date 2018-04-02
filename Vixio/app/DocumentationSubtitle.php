<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentationSubtitle extends Model
{
    public function title(){
    	return $this->belongsTo(DocumentationTitle::class, 'title_id');
    }

    public function content(){
    	return $this->hasMany(DocumentationContent::class, 'subtitle_id');
    }
}
