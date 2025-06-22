 <form {!! $attributes->merge(['class' => '']) !!} method="POST">
     @method('DELETE')
     @csrf
     <button type="submit" class="p-2">
         <img src="{{ asset('assets/icons/delete.png') }}" alt="__delete">
     </button>
 </form>
