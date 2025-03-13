<img
    src="{{
        isset($avatar) ?
        (str_starts_with($avatar, "https:")) ? $avatar : config('app.FILES_URL') . $avatar
        : (isset($default) ? $default : asset('assets/img/avatars/avatar-default.webp')) }}"
     class="avatar {{isset($class) ? $class : "card-img-top w-full"}}"
    alt="{{isset($alt) ? $alt : "Imagen autónomo"}}">

