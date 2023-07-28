<head>
    <title>作業一覧</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}" >
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
</head>

<x-app-layout>
    <x-slot name="header">

        <div class="top">
            <a href="{{route('todo_items.index')}}">作業一覧</a>
        </div>

        <div class="search">
            <form method="get" action="{{route('todo_items.index')}}">
                <input type="text" name="keyword" id="keyword" value="{{$keyword}}">
                <div class="search-btn">
                    <input type="submit" value="検索">
                </div>
            </form>
        </div>
            
        <div class="search-msg">
            @if($keyword != " ")
                キーワード「{{$keyword}}」で検索
            @endif
        </div>

        <x-message :message="session('message')"/>
    </x-slot>

    <div class="flex justify-center mt-4">
        <x-create-button>作業登録</x-create-button>
    </div>
    
    <div class="center">
        <table class="table table1">
            <tr>
                <th class="item">項目名</th>
                <th class="user-name">担当者</th>
                <th class="date">登録日</th>
                <th class="date">期限日</th>
                <th class="date">完了日</th>
                <th class="controll">操作</th>
            </tr>
            
            @foreach($todo_items as $todo_item)
                @if($todo_item->is_deleted == 0)
                    <tr>
                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete item"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger item"
                            @endif>
                            {{$todo_item->item_name}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete user-name"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger user-name"
                            @endif>
                            {{$todo_item->user->name}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            {{$todo_item->registration_date}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            {{$todo_item->expire_date}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            @if(is_null($todo_item->finished_date))
                            未
                            @else    
                            {{$todo_item->finished_date}}
                            @endif
                        </td>

                        <td class="buttons">
                            <div class="button blue">
                                <form method="post" action="{{route('complete',$todo_item)}}">
                                    @csrf
                                    <button type="submit">完了</button>
                                </form>
                            </div>
                        
                        
                            <div class="button green">
                                <button><a href="{{route('todo_items.edit',$todo_item)}}">修正</a></button>
                            </div>
                        
                            <div class="button red">
                                <button><a href="{{route('todo_items.show',$todo_item)}}">削除</a></button>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>

    </div>
    
    <div class="flex justify-center mt-4">
        {{ $todo_items->links('vendor.pagination.tailwind') }}
    </div>


</x-app-layout>