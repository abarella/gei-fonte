@extends('adminlte::page')

@section('title', 'GEI - Emissor')

@section('content_header')
    <h5 class="m-0">Emissor</h5>
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stop

<style>
#modalMin .modal-footer {
  display: none;
}

#modalMinAdd .modal-footer {
  display: none;
}

</style>




@section('content')

</div>


    <form method="POST"  action="{{ route('emissor.index') }}"  class="form-data-table align-center" id='form1'>
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-adminlte-button icon="fa fa-plus" data-toggle="modal"  data-target="#modalMinAdd" class="btn btn-default text-primary mx-1 shadow" label="Adicionar" title="Adicionar"/>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                @php
                                    $result = App\Http\Controllers\EmissorController::listaEmissor();

                                    $heads1 = [
                                        ['label' => '', 'width' => '10'],
                                        ['label' => 'ID', 'width' => 10],
                                        ['label' => 'DESCRIÇÃO', 'width' => 999],
                                    ];

                                    $config1 = [
                                        'data1' =>$result,
                                        'responsive' => true,
                                        'order1' => [[1, 'desc']],
                                        'columns1' => [null, null],
                                        'stateSave'=>true,
                                        'lengthMenu'=> [[5 ,10, 25, 50, -1],['5 registros','10 registros', '25 registros', '50 registros', 'Todos']],
                                        ];

                                    $config1['paging'] = true;

                                    $config1['language'] = [ 'url' => 'https://cdn.datatables.net/plug-ins/2.0.7/i18n/pt-BR.json' ];






                                @endphp
                                <x-adminlte-datatable id="table2" :heads="$heads1" head-theme="light" :config="$config1" striped hoverable bordered compact compressed  with-buttons>
                                    @foreach($config1['data1'] as $row1)

                                    <tr>
                                        <td>
                                            <x-adminlte-button data-toggle="modal" data-target="#modalMin" class="btn btn-default text-primary mx-1 shadow" title="Edit"   icon="fas fa-pen"    data-id="{{ $row1['id'] }}"  data-descricao="{{ $row1['descricao'] }}" ></x-adminlte-button>
                                            <x-adminlte-button data-toggle="modal"  class="btn btn-default text-danger  mx-1 shadow  btn-delete" title="Delete" icon="fas fa-trash"  data-id="{{ $row1['id'] }}"></x-adminlte-button>




                                        </td>

                                        @foreach($row1 as $cell1)
                                            <td>{!! $cell1 !!}</td>
                                        @endforeach

                                    </tr>
                                    @endforeach
                                </x-adminlte-datatable>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    @push('js')


    <script>
        $(document).ready(function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');


            $('#modalMin').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botão que disparou o modal
                var id = button.data('id'); // Extraindo informações dos atributos data-*
                var descricao = button.data('descricao');

                // Atualizando o conteúdo do modal.
                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#descricao').val(descricao);

                // Atualizando a ação do formulário com o ID correto
                var formAction = "{{ route('emissor.update', ':emissor') }}";
                formAction = formAction.replace(':emissor', id);
                modal.find('#form2').attr('action', formAction);


            $('#modalMinAdd').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botão que disparou o modal
                var descricao = button.data('descricao');
                // Atualizando o conteúdo do modal.
                var modal = $(this);
                modal.find('#descricao').val(descricao);
                // Atualizando a ação do formulário com o ID correto
                var formAction = "{{ route('emissor.store', ':emissor') }}";
                formAction = formAction.replace(':emissor', id);
                modal.find('#form3').attr('action', formAction);
            })




        });


        //Executa o Update do Status da Solicitação
        $('#form2').on('submit', function(e) {
                //console.log('Formulário enviado'); // Adicione isso
                e.preventDefault();
                //const solicitacaoId = $(this).attr('data-id');
                const solicitacaoId = $('#id').val();
                const form = $(this)[0];
                const formData = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: `${baseUrl}/emissor/${solicitacaoId}`,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        $('#modalMin').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors && Object.keys(errors).length > 0) {
                                let errorMessage = '';
                                Object.keys(errors).forEach(fieldName => {
                                    errorMessage += errors[fieldName][0] + '\n';
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao analizar solicitação!',
                                    text: 'Campo(s) obrigatório(s) não foi(foram) preenchido(s)!',
                                    showConfirmButton: true,
                                });
                            }
                        } else {
                            showMessagesAndClearSession();
                        }
                    }
                });
            });
        });


        //Executa o Insert do Status da Solicitação
        $('#form3').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(response) {
                $('#modalMinAdd').modal('hide');
                location.reload();
            },
            error: function(response) {
                // Exibe as mensagens recuperadas da sessão
                showMessagesAndClearSession();
            }
        });
    });




// Metodo delete de Emissor com confirmação através do sweetalert2
$(document).on('click', '.btn-delete', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

    const emissorId = this.getAttribute('data-id');

Swal.fire({
    title: 'Tem certeza que deseja deletar o Emissor #' + emissorId + '?',
    text: "Você não poderá reverter isso!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sim, deletar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {
        fetch( `${baseUrl}/emissor/${emissorId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (response.ok) {
                response.json().then(data => {
                    Swal.fire({
                        title:  'Emissor Deletado com Sucesso!',
                        text: data.success_del_eqpto,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                });
            } else {
                response.json().then(data => {
                    Swal.fire({
                        title:  'Erro ao Deletar o Emissor',
                        text: data.error_del_eqpto,
                        icon: 'warning',
                        showConfirmButton: false,
                        showCancelButton: false,
                    });
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title:  'Erro ao Deletar o Emissor',
                icon: 'warning',
                showConfirmButton: false,
                showCancelButton: false,
            });
        });
    }

});

})





    </script>
    @endpush






<x-adminlte-modal id="modalMin" title="Emissor" size="md" theme="teal" icon="fas fa-star" v-centered static-backdrop scrollable>
    <form method="POST"  action="{{ route('emissor.update', ['emissor' => 0]) }}"  class="form-data-table align-center" id='form2' name='form2' >
        @csrf
        @method('PUT')

        <div style="height:200px;">
            &nbsp;<label for="id" class="form-label">Nº</label>
            <input type='text' id="id"        name="id"        class='form-control' readonly />

            &nbsp;<label for="descrição" class="form-label">Descrição</label>
            <input type='text' id="descricao" name="descricao" class='form-control'/>
        </div>
        <div class="card-body" name="footerSlot">
            <x-adminlte-button name="salvarEmissor" id="salvarEmissor" class="btn-flat" type="submit" label="Salvar" theme="success" icon="fas fa-lg fa-save"></x-adminlte-button>
            <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
        </div>
    </form>
</x-adminlte-modal>

<x-adminlte-modal id="modalMinAdd" title="Emissor" size="md" theme="teal" icon="fas fa-star" v-centered static-backdrop scrollable>
    <form method="POST"  action="{{ route('emissor.store') }}"  class="form-data-table align-center" id='form3' name='form3' >
        @csrf


        <div style="height:200px;">
            &nbsp;<label for="descrição" class="form-label">Descrição</label>
            <input type='text' id="descricao" name="descricao" class='form-control'/>
        </div>
        <div class="card-body" name="footerSlot">
            <x-adminlte-button name="addEmissor" id="addEmissor" class="btn-flat" type="submit" label="Salvar" theme="success" icon="fas fa-lg fa-save"></x-adminlte-button>
            <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
        </div>
    </form>
</x-adminlte-modal>




@stop
