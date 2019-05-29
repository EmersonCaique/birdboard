<template>
    <div class="mr-4">
        <button
            class="rounded-full w-4 h-4 border mr focus:outline-none bg-white"
            :class="{'border-blue': theme == 'theme-light' } "
            @click.prevent='theme = "theme-light"'></button>

        <button
            class="rounded-full w-4 h-4 border mr focus:outline-none bg-black"
            :class="{'border-blue': theme == 'theme-dark' } "
            @click.prevent='theme = "theme-dark"'></button>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                theme: 'theme-light'
            }
        },
        watch: {
            theme(){
                document.body.className = document.body.className.replace(/theme-\w+/,this.theme)
                localStorage.setItem('theme', this.theme)
            }
        },
        mounted(){
            this.theme = localStorage.getItem('theme') || 'theme-light'
        }
    }

</script>
