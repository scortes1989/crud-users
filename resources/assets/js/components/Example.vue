<template>
    <div>
        <panel>
            <h3 slot="title">
                {{ name }}

                <a href="#dlgNewUser" class="btn btn-primary" data-toggle="modal">Nuevo</a>
            </h3>

            <div v-if="alert_success" class="alert alert-success">
                {{ alert_success }}
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role ? user.role.name : '' }}</td>
                        <td>
                            <div v-if="user.files">
                                <img width="100%" :src="user.files.path">
                            </div>
                        </td>
                        <td>
                            <a @click="load(user.id)" href="#dlgEditUser" data-toggle="modal" class="btn btn-primary">
                                Editar
                            </a>
                            <a @click="load(user.id)" href="#dlgDeleteUser" data-toggle="modal" class="btn btn-primary">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </panel>

        <div class="modal fade" id="dlgNewUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <div :class="error_class">
                            <input type="text" class="form-control" v-model="create.name" placeholder="Nombre">
                            <p v-if="create_errors.name" class="text-danger">{{ create_errors.name[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <input type="email" class="form-control" v-model="create.email" placeholder="Email">
                            <p v-if="create_errors.email" class="text-danger">{{ create_errors.email[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <input type="password" class="form-control" v-model="create.password" placeholder="Contraseña">
                            <p v-if="create_errors.password" class="text-danger">{{ create_errors.password[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <select class="form-control" v-model="create.role_id">
                                <option value="">--Seleccione--</option>
                                <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                            </select>
                            <p v-if="create_errors.role_id" class="text-danger">{{ create_errors.role_id[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <input type="file" id="file" @change="loadImage">
                        </div>

                        <div id="preview" v-if="image_preview">
                            <img :src="image_preview" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="store">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="dlgEditUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <div :class="error_class">
                            <input type="text" class="form-control" v-model="user.name" placeholder="Nombre">
                            <p v-if="edit_errors.name" class="text-danger">{{ edit_errors.name[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <input type="email" class="form-control" v-model="user.email" placeholder="Email">
                            <p v-if="edit_errors.email" class="text-danger">{{ edit_errors.email[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <input type="password" class="form-control" v-model="user.password" placeholder="Contraseña">
                            <p v-if="edit_errors.password" class="text-danger">{{ edit_errors.password[0] }}</p>
                        </div>

                        <div :class="error_class">
                            <select class="form-control" v-model="user.role_id">
                                <option value="">--Seleccione--</option>
                                <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                            </select>
                            <p v-if="edit_errors.role_id" class="text-danger">{{ edit_errors.role_id[0] }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="update">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="dlgDeleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">¿Estas seguro de eliminar este Usuario ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-primary" @click="destroy">SI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import User from '../Models/User';

    export default {
        data: function () {
            return {
                error_class: 'form-group',
                alert_success: false,
                image_preview: false,
                roles: [],
                users: [],
                user: {},
                create: {
                    role_id: ''
                },
                create_errors: {},
                edit_errors: {}
            }
        },

        props: ['name'],

        created() {
            this.loadData();
            this.index();

        },

        methods: {
            loadData() {
                axios.get('/api/v1/core/roles')
                    .then(({data}) => {
                        this.roles = data.data;
                    });
            },

            index() {
                User.get(data => this.users = data);
            },

            load(element) {
                User.show(element, data => this.user = data);
            },

            store() {
                var file = document.getElementById('file').files[0];

                var formData = new FormData();
                formData.append('name', this.create.name);
                formData.append('email', this.create.email);
                formData.append('password', this.create.password);
                formData.append('role_id', this.create.role_id);
                formData.append('file', file);

                axios.post('/api/v1/core/users', formData)
                    .then(({data}) => {
                        this.create = {
                            role_id: ''
                        };
                        this.alert_success = 'Usuario registrado correctamente';
                        this.index();
                        $('#dlgNewUser').modal('hide');
                    })
                    .catch(error => {
                        this.error_class = 'form-group has-error';
                        this.create_errors = error.response.data;
                    });
            },

            update() {
                this.user._method = 'PUT';

                axios.post('/api/v1/core/users/' + this.user.id, this.user)
                    .then(({data}) => {
                        this.alert_success = 'Usuario modificado correctamente';
                        this.index();
                        $('#dlgEditUser').modal('hide');
                    })
                    .catch(error => {
                        this.error_class = 'form-group has-error';
                        this.edit_errors = error.response.data;
                    });
            },

            destroy() {
                axios.delete('/api/v1/core/users/' + this.user.id)
                    .then(({data}) => {
                        this.alert_success = 'Usuario eliminado correctamente';
                        this.index();
                        $('#dlgDeleteUser').modal('hide');
                    });
            },

            loadImage(event) {
                var input = event.target;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.image_preview = e.target.result;
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            },
        }
    }
</script>
