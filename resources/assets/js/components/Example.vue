<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <panel>
                    <h3 slot="title">{{ title }}</h3>

                    {{ users }}

                    <span :style="{ color: activeColor, fontSize: fontSize + 'px' }">{{ name }}</span>
                </panel>
            </div>
        </div>


        <roles></roles>
        <users></users>
    </div>
</template>

<script>
    import User from '../Models/User';

    export default {
        data: function () {
            return {
                title: '',
                activeColor: 'blue',
                fontSize: 12,
                users: []
            }
        },

        computed: {
            title2() {
                return this.title.toUpperCase();
            }
        },

        props: ['name'],

        created() {
            this.index();
        },

        methods: {
            index() {
                this.users = User.get();
            },
            changeTitle() {
                this.title = 'El titulo ha sido modificado';
            }
        }
    }
</script>
