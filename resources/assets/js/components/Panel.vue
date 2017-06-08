<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading"><slot name="title"></slot></div>

            <slot>Perror</slot>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        }
    }
</script>
