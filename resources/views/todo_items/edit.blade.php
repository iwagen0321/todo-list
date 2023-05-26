<head>
    <title>作業修正</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}" >
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
</head>

<x-app-layout>
    <x-slot name="header">
        
        <div class="top">
            作業修正
        </div>
        
        <div>ようこそ{{Auth::user()->login_id}}さん</div>

        <x-input-error class="mb-4 msg" :messages="$errors->all()"/>
        <x-message :message="session('message')"/>
    </x-slot>


    <div class="center">
        <form method="post" action="{{route('todo_items.update',$todo_item)}}">
        @csrf
        @method('patch')

            <div>
                <label for="item_name">項目名</label><br>
                <input class="create" type="text" name="item_name" id='item_name' value="{{$todo_item->item_name}}">
            </div>

            <div>
                <label for="user_id">担当者</label><br>
                <select class="create" name="user_id" id="user_id">
                    <option>--選択してください--</option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @if($todo_item->user_id == $user->id)
                                selected
                            @endif
                        >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
                
            <div>
                <label for="expire_date">期限</label><br>
                    <input class="create" type="date" name="expire_date" value="{{$todo_item->expire_date}}">
            </div>

            <div class="create">
                <input type="checkbox" name="finished_date" id="finished_date" value="1" 
                @if($todo_item->finished_date)
                checked
                @endif
                >完了
            </div>
            
            
            <x-primary-button>更新</x-primary-button>
            <x-cancel-button>キャンセル</x-cancel-button>

        </form>

    </div>


</x-app-layout>