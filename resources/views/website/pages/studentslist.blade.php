<tbody id="student_list">
    @foreach ($readingcycles as $readingcycle)                        
    <tr>
        <td>{{ $readingcycle->student->name }}</td>
        @for ($i=1;$i<31;$i++)
        <td>
            <?php $key="part_".$i; ?>
            @if ($readingcycle->$key == 1)    
            <button class="btn btn-success unsaved_part" id="student_{{ $readingcycle->id }}_{{ $i }}" data-part="{{ $i }}" data-reading_cycle="{{ $readingcycle->id }}" >
                <i class="ti-check"></i>
            </button>
            @else
            <button class="btn btn- saved_part"  id="student_{{ $readingcycle->id }}_{{ $i }}" data-part="{{ $i }}" data-reading_cycle="{{ $readingcycle->id }}">X</button>
            @endif
        </td>
        @endfor
        
    </tr>
    @endforeach
    @if (count($readingcycles)==0)
        
    <tr>
        <td colspan="31">
            <div class="alert alert-danger  text-center">لا تــوجـد بـيـانـــات</div>
        </td>
    </tr>
    @endif
</tbody>