<?php

namespace App\Models;


class DocumentSource {
    public string $source_name = '';
    public bool $has_source = false;
    public int | null $source_id = null;
    public int | null $source_template_id = null;
}

