<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentationContent extends Model
{
    public function subtitle(){
    	return $this->belongsTo(DocumentationSubtitle::class, 'subtitle_id');
    }
}
