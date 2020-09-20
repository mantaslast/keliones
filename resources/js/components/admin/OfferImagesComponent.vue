<template>
    <div>
        <div id="drag-and-drop"></div>
    </div>
</template>

<script>
    import { DragAndDrop } from "../../helpers/imageupl/drag-and-drop.js";


    export default {
        props:['imgs'],
        mounted : function () {
            const element = document.querySelector("#drag-and-drop");
            const dragAndDrop = new DragAndDrop(element);
            dragAndDrop.run();
            if (this.imgs && this.imgs.length > 0) {
                this.imgs.forEach(function(el) {
                    let imageEl = document.createElement('img');
                    imageEl.src = '/files/' + el
                    document.getElementById('gallery').appendChild(imageEl)
                })
            }
        }
    }
</script>
