<div {{$attributes->merge(['class'=>'card'])}}>
    <div class="card-body">
        <h4 class="">
            {{$title??"No title"}}
        </h4>
        <hr>
        {{$slot}}
    </div>
</div>
