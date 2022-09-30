{{-- Form for a $group with $prefix --}}
@if (isset($standalone) && $standalone)
<form method="POST" action="">
    @csrf
@endif
    <div class="container-fluid beluga-form-group beluga-{{ $shell->getName() }}-group mb-3" id="beluga-{{ $shell->getName() }}-group-{{ $name }}">
        <div class="row">
            {{-- If $group have label show it --}}
            @if(isset($group->label))
                <div class="beluga-form-label">
                    <h1>{{ $group->label }}</h1>
                </div>
            @endif

            {{-- If $group have description show it --}}
            @if(isset($group->description))
                <div class="beluga-form-description">
                    <h3>{{ $group->description }}</h3>
                </div>
            @endif

            @if (isset($group->label))
                <hr class="border-2 border-top border-primary">
            @endif

            {{-- Loop for each data in $group->datas --}}
            @if (isset($group->datas))
                @if (isset($group->render) && $group->render == 'one-line')
                    <div class="row">
                    @foreach($group->datas as $dataName => $data)
                        {{-- include input component --}}
                        <x-beluga-input :shell="$shell" :name="$dataName" :prefix="$prefix" :internal="$internal" />
                    @endforeach
                    </div>
                @else
                    @foreach($group->datas as $dataName => $data)
                    <div class="beluga-data-{{ $dataName }}">
                        <div class="row">
                            {{-- include input component --}}
                            <x-beluga-input :shell="$shell" :name="$dataName" :prefix="$prefix" :internal="$internal" />
                        </div>
                    </div>
                    @endforeach
                @endif
            @endif

            
            @if (isset($group->render) && $group->render == 'table')
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <?php $first_group = $group->groups->{array_keys((array) $group->groups)[0]}; ?>
                            @foreach($first_group->datas as $data)
                                <th>{{ $data->label }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group->groups as $name => $group2)
                            <tr>
                                <td>{{ $group2->label }}</td>
                                @foreach($group2->datas as $data)
                                    <td>
                                        <x-beluga-field :shell="$shell" :name="$data->name" :prefix="$prefix.'-'.$name.'-'" :internal="$internal" />
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{-- Loop for each group in $group->groups --}}
                @if(isset($group->groups))
                    @foreach($group->groups as $name => $group)
                        {{-- include group component --}}
                        <x-beluga-group :shell="$shell" :name="$name" :prefix="$prefix" :internal="$internal" />
                    @endforeach
                @endif
            @endif
        </div>
    </div>
@if (isset($standalone) && $standalone)
</form>
@endif
