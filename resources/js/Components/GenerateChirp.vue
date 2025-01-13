
<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'


const chirps = ref({});
const loading = ref(false);
const modalOpen = ref(false);
const selectedChirp = ref(null);


const generateChirps = async () => {
  loading.value = true;
  modalOpen.value = false;
  selectedChirp.value = null;

  try {
    const response = await axios.post(route('generate.chirps'));
    console.log(response);
  const arr= ["funny", "neutral", "serious"].map((state)=>{
  const message = response.data[state].choices.pop().message.content
  console.log(message);
return message
})
    chirps.value = arr
    loading.value = false;
    modalOpen.value = true;
  } catch (error) {
    console.error('Error generating chirps:', error);
    loading.value = false;
  }
};


const closeModal = () => {
  modalOpen.value = false;

};

const saveChirp = async (chirp) => {
  try {
    await axios.post(route('chirps.store'), { message: chirp });
    window.location.href = route('chirps.index');
    closeModal();
  } catch (error) {
    console.error('Error saving chirp:', error);
  }
};
</script>
<template>
    <div>
      <SecondaryButton class="mt-2" @click="generateChirps">Random chirp</SecondaryButton>
      <div v-if="loading" class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg p-6 lg:overflow-visible">
  <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"
    width="24" height="24">
    <path
      d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
      stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
    <path
      d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
      stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
    </path>
  </svg>
</div>
      <div v-if="modalOpen" class="mt-6 bg-white shadow-sm rounded-lg divided-y" >
        <div class="flex justify-between p-2">
          <h3 class="text-xl font-semibold leading-tight text-gray-800 ">Select a random chirp:</h3>
          <button @click="closeModal" class="inline-flex items-center justify-center rounded-md  text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"><svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path><path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
          <div  class="p-6 flex justify-between mt-4 bg-white shadow-sm rounded-lg divide-y" v-for="(chirp, i) in chirps" :key="i">
            <p class="text-lg text-gray-900">{{ chirp }}</p>
            <PrimaryButton class="h-10 text-nowrap self-center" @click="saveChirp(chirp)">I choose u</PrimaryButton>
          </div>
         
    
      </div>
    </div>
  </template>