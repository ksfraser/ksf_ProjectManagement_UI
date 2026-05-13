<?php

namespace Ksfraser\HTML;

class HTMLBuilder
{
    public function div(array $attrs): string
    {
        $class = $attrs['class'] ?? '';
        $content = $attrs['content'] ?? '';
        
        if (is_array($content)) {
            $content = implode('', $content);
        }
        
        return '<div' . ($class ? ' class="' . htmlspecialchars($class) . '"' : '') . '>' . $content . '</div>';
    }
    
    public function span(array $attrs): string
    {
        $class = $attrs['class'] ?? '';
        $content = $attrs['content'] ?? '';
        
        if (is_array($content)) {
            $content = implode('', $content);
        }
        
        return '<span' . ($class ? ' class="' . htmlspecialchars($class) . '"' : '') . '>' . $content . '</span>';
    }
    
    public function input(array $attrs): string
    {
        $parts = [];
        
        foreach ($attrs as $key => $value) {
            if ($key !== 'content') {
                $parts[] = $key . '="' . htmlspecialchars((string)$value) . '"';
            }
        }
        
        return '<input ' . implode(' ', $parts) . '>';
    }
    
    public function select(array $attrs): string
    {
        $class = $attrs['class'] ?? '';
        $name = $attrs['name'] ?? '';
        $options = $attrs['options'] ?? [];
        
        $html = '<select' . ($class ? ' class="' . htmlspecialchars($class) . '"' : '') . ' name="' . htmlspecialchars($name) . '">';
        
        foreach ($options as $value => $label) {
            $html .= '<option value="' . htmlspecialchars((string)$value) . '">' . htmlspecialchars($label) . '</option>';
        }
        
        $html .= '</select>';
        
        return $html;
    }
}
