 <form wire:submit="save">
     <div class="grid lg:grid:cols-12 md:grid-cols-12 sm:grid-cols-12">
         <div class="lg:col-span-6 md:col-span-12 sm:col-span-12 border border-base-500 p-5 rounded">
             <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.request_title" required="yes">
                         {{ __('Request Title') }}
                     </x-forms.label>
                     <x-forms.text-input wire:model="form.request_title" type="text" />
                     <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-1 sm:grid-cols-1 p-2 w-full">
                 <x-forms.label for="form.request_description" required="yes">
                     {{ __('Request Description') }}
                 </x-forms.label>
                 <div wire:ignore>
                     <textarea wire:ignore cols="30" id="editor" rows="10" wire:model.lazy='form.request_description'
                         class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                         placeholder="Add description here.."></textarea>
                 </div>
                 <x-input-error :messages="$errors->get('form.request_description')" class="mt-2" />
             </div>

             <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2 w-full">
                     <x-forms.input-file wire:model="form.request_attachment" multiple
                         accept=".jpg,.jpeg, .png,.pdf,.docx,.ppt" />
                     <x-input-error :messages="$errors->get('form.request_attachment')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_name" required='yes'>
                         {{ __('Requester Name') }}
                     </x-forms.label>
                     <x-forms.text-input type="text" wire:model='form.requester_name' />
                     <x-input-error :messages="$errors->get('form.requester_name')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_email" required="yes">
                         {{ __('Requester Email') }}
                     </x-forms.label>
                     <x-forms.text-input wire:model="form.requester_email" type="email" />
                     <x-input-error :messages="$errors->get('form.requester_email')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_phone">
                         {{ __('Requester Phone') }}
                     </x-forms.label>
                     <x-forms.text-input type="number" wire:model='form.requester_phone' />
                     <x-input-error :messages="$errors->get('form.requester_phone')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_type">
                         {{ __('Requester Type') }}
                     </x-forms.label>

                     <x-forms.select-input wire:model="form.requester_type_id">
                         <option>Requester type</option>
                         @foreach ($requester_type as $each)
                         <option value="{{ $each->id }}" :key="{{ $each->id }}">{{ $each?->name }}
                         </option>
                         @endforeach
                     </x-forms.select-input>

                     <x-input-error :messages="$errors->get('form.requester_type_id')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2 w-full">
                     <x-forms.label for="form.requester_id">
                         {{ __('Requester ID') }}
                     </x-forms.label>
                     <x-forms.text-input type="text" wire:model='form.requester_id' />
                     <x-input-error :messages="$errors->get('form.requester_id')" class="mt-2" />
                 </div>
                 <div class="p-2 w-full">
                     <x-forms.label for="form.priority" required="yes">
                         {{ __('Priority') }}
                     </x-forms.label>
                     <div class="mt-3 flex gap-2 items-center">
                         <div class="flex items-center">
                             <label class="flex gap-1 items-center">
                                 <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2" value="low" />
                                 <span class="text-paragraph ml-2">Low</span>
                             </label>
                         </div>
                         <div class="flex items-center">
                             <label class="flex gap-1 items-center">
                                 <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2" value="medium" />
                                 <span class=" text-paragraph ml-2">Medium</span>
                             </label>
                         </div>
                         <div class="flex items-center">
                             <label class="flex gap-1 items-center">
                                 <x-forms.radio-input wire:model="form.priority" name="priority" class="ml-2" value="high" />
                                 <span class="text-paragraph ml-2">High</span>
                             </label>
                         </div>
                     </div>
                     <x-input-error :messages="$errors->get('form.priority')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2">
                     <x-forms.label for="form.due_date">
                         {{ __('Due Date') }}
                     </x-forms.label>
                     <x-forms.text-input type="date" wire:model='form.due_date' />
                     <x-input-error :messages="$errors->get('form.due_date')" class="mt-2" />
                 </div>

                 <div class="p-2">
                     <x-forms.label for="form.source_id">
                         {{ __('Source') }}
                     </x-forms.label>

                     <x-forms.select-input wire:model="form.source_id">
                         <option>Source</option>
                         @foreach ($sources as $each)
                         <option value="{{ $each->id }}" :key="{{ $each->id }}">{{ $each?->title }}
                         </option>
                         @endforeach
                     </x-forms.select-input>

                     <x-input-error :messages="$errors->get('form.source_id')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2">
                     <x-forms.label for="category_id" required="yes">
                         {{ __('Category') }}
                     </x-forms.label>

                     <div>
                         <x-forms.select-input wire:model="form.category_id" wire:change="selectChildeCategory">
                             <option value="">Select Category</option>
                             @foreach ($categories as $each)
                             <option value="{{ $each?->id }}" :key="{{ $each->id }}">
                                 {{ $each?->name }}
                             </option>
                             @endforeach
                         </x-forms.select-input>
                         <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />

                         @if ($subCategory && $subCategory->count() > 0)
                         <div class="mt-3">
                             <x-forms.label for="sub_category_id" required="yes">
                                 {{ __('Sub Category') }}
                             </x-forms.label>
                             <x-forms.select-input wire:model="form.sub_category_id" id="sub_category_id">
                                 <option value="">Select Sub Category</option>
                                 @foreach ($subCategory as $each)
                                 <option value="{{ $each?->id }}" :key="{{ $each->id }}">
                                     {{ $each?->name }}
                                 </option>
                                 @endforeach
                             </x-forms.select-input>
                             <x-input-error :messages="$errors->get('form.sub_category_id')" class="mt-2" />
                         </div>
                         @endif

                     </div>
                 </div>
                 <div class="p-2">
                     <x-forms.label for="form.ticket_status_id" required="yes">
                         {{ __('Status') }}
                     </x-forms.label>

                     <x-forms.select-input wire:model="form.ticket_status_id">
                         <option value="">Select status</option>
                         @foreach ($ticket_status as $status)
                         <option value="{{ $status->id }}" :key="{{ $status->id }}">{{ $status->name }}
                         </option>
                         @endforeach
                     </x-forms.select-input>

                     <x-input-error :messages="$errors->get('form.ticket_status_id')" class="mt-2" />
                 </div>
             </div>

             <div class="grid md:grid-cols-3 sm:grid-cols-1 sm:gap-1 md:gap-2">
                 <div class="p-2">
                     <x-forms.label for="department_id_select">
                         {{ __('Select Department') }}
                     </x-forms.label>
                     <div>
                         <x-forms.select-input wire:model="form.department_id" wire:change="selectDepartemntTeam">
                             <option value="">Select Department</option>
                             @foreach ($departments as $each)
                             <option value="{{ $each->id }}" :key="{{ $each->id }}">
                                 {{ $each?->name }}
                             </option>
                             @endforeach
                         </x-forms.select-input>
                         <x-input-error :messages="$errors->get('form.department_id')" class="mt-2" />
                     </div>
                 </div>
                 <div class="p-2">
                     <x-forms.label for="team_id_select">
                         {{ __('Select Team') }}
                     </x-forms.label>
                     <div>
                         <x-forms.select-input wire:model="form.team_id" wire:change="selectTeamAgent">
                             <option value="">Select Team</option>
                             @foreach ($teams as $each)
                             <option value="{{ $each->id }}" :key="{{ $each->id }}">
                                 {{ $each?->name }}
                             </option>
                             @endforeach
                         </x-forms.select-input>
                         <x-input-error :messages="$errors->get('form.team_id')" class="mt-2" />
                     </div>
                 </div>

                 <div class="p-2">
                     <x-forms.label for="form.owner_id">
                         {{ __('Select Agent') }}
                     </x-forms.label>
                     <div>
                         <x-forms.select-input wire:model="form.owner_id">
                             <option value="">Select Agent</option>
                             @foreach ($teamAgent as $each)
                             <option value="{{ $each?->id }}" :key="{{ $each->id }}">
                                 {{ $each?->name }}
                             </option>
                             @endforeach
                         </x-forms.select-input>
                     </div>

                     <x-input-error :messages="$errors->get('form.owner_id')" class="mt-2" />
                 </div>
             </div>
             <div class="p-2 mt-[7px]">
                 <x-buttons.primary>
                     Create Request
                 </x-buttons.primary>
             </div>
         </div>
     </div>
 </form>

 @section('style')
 <style>
     .ck-editor__editable_inline {
         min-height: 200px;
     }
 </style>
 @endsection
 @section('script')
 <script>
     const editor = ClassicEditor
         .create(document.querySelector('#editor'))
         .then(editor => {
             editor.model.document.on('change:data', () => {
                 @this.set('form.request_description', editor.getData());
             })
         })
         .catch(error => {
             console.error(error);
         });

     document.addEventListener('DOMContentLoaded', function() {

         let attachment = document.querySelector('#attachment');
         let attachmentName = document.querySelector('#attachmentName');

         attachment.addEventListener('change', function(event) {
             event.preventDefault();
             let files = event.target.files;
             if (files.length > 0) {
                 let filename = files[0].name;
                 attachmentName.innerHTML = filename;
             }
         });

         //  initSelect2form('category_id');
     });
 </script>
 @endsection