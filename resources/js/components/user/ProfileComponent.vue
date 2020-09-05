<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div @click="test" class="testinis">
                        asdasd
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data : ()=>({
            asd : 1,
            www : 2
        }),
        methods: {
            test(){
                fetch('/api/testas').then(response=>response.json())
                .then(response=>{
                    console.log(response)
                })
            }
        }
    }
</script>
