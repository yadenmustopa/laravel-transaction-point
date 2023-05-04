<script>
    import { onMount } from "svelte";
    let user = "User";
    export let data;

    onMount(()=>{
        console.log({ data });
    });
</script>

<div>
    <h1>Hello { user }!</h1>
    <div class="text-base text-cyan-400">Cek Cek</div>
</div>
