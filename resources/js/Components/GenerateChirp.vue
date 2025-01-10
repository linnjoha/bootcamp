<script >
import PrimaryButton from '@/Components/PrimaryButton.vue';
export default {
  data() {
    return {
      chirps: {},
      loading: false,
      modalOpen: false,
      selectedChirp: null
    }
  },

  methods: {

    generateChirps() {
      this.loading = true
      this.modalOpen = false
      this.selectedChirp = null

    
      axios.post(route('generate.chirps'))
         .then((response) => {
            const obj=response.data.pop().message.content
          console.log(obj);
           this.chirps =obj.split(':')
           console.log(this.chirps);
           this.loading = false
           this.modalOpen = true
         })
         .catch((error) => {
           console.error('Error generating chirps:', error)
       this.loading = false
         })
    },


 
    closeModal() {
      this.modalOpen = false
      this.selectedChirp = null
    },

 
    saveChirp(chirp) {
   
      this.selectedChirp = chirp
  
      axios.post(route('chirps.store'), { message: this.selectedChirp })
        .then((response) => {
          this.$inertia.visit(route('chirps.index'), { method: 'get' })
          this.closeModal()
        })
        .catch((error) => {
          console.error('Error saving chirp:', error)
        })
    }
  }
}
</script>

<template>
    <div>
      <button @click="generateChirps" class="btn btn-primary">Random chiirp</button>
      <div v-if="loading" class="spinner">
        Loading...
      </div>
      <div v-if="modalOpen" class="modal">
        <div class="modal-content">
          <h3>Select a Chirp:</h3>
          <div v-for="(chirp, level) in chirps" :key="level">
            <p class="btn btn-secondary">{{ chirp }}</p>
            <button @click="saveChirp(chirp)" class="btn btn-success">
              Cherp, i chose u
            </button>
          </div>
          <button @click="closeModal" class="btn btn-danger">Cancel</button>
        </div>
      </div>
    </div>
  </template>