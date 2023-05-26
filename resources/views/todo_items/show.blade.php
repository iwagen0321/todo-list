<head>
    <title>削除確認</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}" >
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
</head>

<x-app-layout>
    <x-slot name="header">
        
        <div class="top">
            削除確認
        </div>
        
        <div>ようこそ{{Auth::user()->login_id}}さん</div>

        <div class="delete-msg">
            下記の項目を削除します。よろしいでしょうか？
        </div>

        <x-input-error class="mb-4 msg" :messages="$errors->all()"/>
        <x-message :message="session('message')"/>
    </x-slot>


    <div class="center">
        <form method="post" action="{{route('todo_items.update',$todo_item)}}">
            <div>
                <label for="item_name">項目名</label><br>
                <p class="create" type="text" name="item_name" id='item_name'>{{$todo_item->item_name}}</p>
            </div>

            <div>
                <label for="user_id">担当者</label><br>
                <p class="create" type="text" name="user_id" id="user_id">
                    @foreach ($users as $user)
                        
                            @if($todo_item->user_id == $user->id)
                                {{$user->name}}
                            @endif
                        
                    @endforeach
                </p>
            </div>
                
            <div>
                <label for="expire_date">期限</label><br>
                    <p class="create" type="date" name="expire_date">{{$todo_item->expire_date}}</p>
            </div>

            <div class="create">
                <input disabled type="checkbox" name="finished_date" id="finished_date" value="1" 
                @if($todo_item->finished_date)
                checked
                @endif
                >完了
            </div>
            
            
            <form method="post" action="{{route('todo_items.destroy',$todo_item)}}">
            @csrf
            @method('delete')

                <x-primary-button>削除</x-primary-button>

                <x-cancel-button>キャンセル</x-cancel-button>
            </form>
            


        </form>

    </div>


</x-app-layout>

