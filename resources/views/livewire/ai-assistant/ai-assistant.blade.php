<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- قائمة المحادثات -->
        <div class="col-md-4 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">المحادثات</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                        <i class="mdi mdi-plus me-1"></i> محادثة جديدة
                    </button>
                </div>
                <div class="card-body conversation-list" style="height: 500px; overflow-y: auto;">
                    @if(count($conversations) > 0)
                        <ul class="list-group">
                            @foreach($conversations as $conversation)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center cursor-pointer {{ $currentConversation && $currentConversation->id == $conversation->id ? 'active' : '' }}"
                                    wire:click="selectConversation({{ $conversation->id }})">
                                    <div>
                                        <h6 class="mb-0">{{ $conversation->title }}</h6>
                                        <small>{{ $conversation->updated_at->format('Y-m-d H:i') }}</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger" wire:click.stop="deleteConversation({{ $conversation->id }})">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-chat-outline mdi-48px text-muted"></i>
                            <p class="mt-2">لا توجد محادثات</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                                ابدأ محادثة جديدة
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- نافذة المحادثة -->
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if($currentConversation)
                            {{ $currentConversation->title }}
                        @else
                            المساعد الذكي
                        @endif
                    </h5>
                </div>
                <div class="card-body chat-container" style="height: 450px; overflow-y: auto;">
                    @if($currentConversation)
                        @foreach($messages as $message)
                            <div class="chat-message mb-3 {{ $message->type == 'user' ? 'text-end' : '' }}">
                                <div class="d-inline-block p-3 rounded {{ $message->type == 'user' ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 80%;">
                                    {!! nl2br(e($message->content)) !!}
                                </div>
                                <div class="mt-1">
                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-robot mdi-48px text-muted"></i>
                            <h4 class="mt-2">مرحباً بك في المساعد الذكي</h4>
                            <p>اختر محادثة من القائمة أو ابدأ محادثة جديدة</p>
                        </div>
                    @endif
                </div>
                @if($currentConversation)
                    <div class="card-footer">
                        <form wire:submit.prevent="sendMessage">
                            <div class="input-group">
                                <textarea wire:model.defer="newMessage" class="form-control" placeholder="اكتب رسالتك هنا..." rows="2"></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-send"></i>
                                </button>
                            </div>
                            @error('newMessage') <span class="text-danger">{{ $message }}</span> @enderror
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal إنشاء محادثة جديدة -->
    <div wire:ignore.self class="modal fade" id="newConversationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">محادثة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">عنوان المحادثة</label>
                        <input type="text" class="form-control" wire:model.defer="newConversationTitle" placeholder="محادثة جديدة">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" wire:click="createNewConversation()" data-bs-dismiss="modal">إنشاء</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // تمرير إلى أسفل المحادثة عند تحميل رسائل جديدة
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'ai-assistant.ai-assistant') {
                const chatContainer = document.querySelector('.chat-container');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            }
        });
    });
</script>
@endpush
