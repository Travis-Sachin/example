<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <h1>
            <b>Signed in as: {{ role }}</b>
          </h1>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="role=='super-admin'">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="shadow-lg bg-white" border="2">
            <tr>
              <th class="bg-blue-100 border text-left px-8 py-4">Name</th>
              <th class="bg-blue-100 border text-left px-8 py-4">Simulate</th>
            </tr>
            <tr v-for="u in users">
              <td border px-8 py-4>{{ u.name }}</td>
              <td border px-8 py-4>
                <inertia-link :href="route('impersonate', u.id)" as="button" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simulate</inertia-link>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- <welcome /> -->

          <div class="col-span-16 sm:col-span-4">
            <form @submit.prevent="submit">
              <jet-label for="file" value="Upload Image" />
              <input
                id="file"
                type="file"
                class="mt-1 block w-full"
                ref="photo"
              />
              <jet-button
                class="mt-2 mr-2"
                type="button"
                @click.native.prevent="upload"
              >
                Upload
              </jet-button>
            </form>
          </div>

          <div v-if="$page.props.flash.success" class="green">
            {{ $page.props.flash.success }}
          </div>

          <!-- <img v-bind:src="images/user.profile_photo_path" v-if="user.profile_photo_path" /> -->
          <img
            :src="route('images', user.profile_photo_path)"
            v-if="user.profile_photo_path"
            height="100"
            width="100"
          />
          <img
            src="https://img.icons8.com/carbon-copy/2x/no-image.png"
            v-else
            height="100"
            width="100"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  components: {
    AppLayout,
    Welcome,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },
  data: function () {
    return {};
  },
  props: {
    role: null,
    user: null,
    errors: Object,
    success: String,
    users: Array,
    admin: Object
  },
  mounted: function () {
    // this.success="working";
    console.log(this.$page.props);
  },
  methods: {
    upload() {
      var data = new FormData();
      var photo = this.$refs.photo.files[0];
      data.append("photo", photo || "");
      s;
      this.$inertia.post("/uploader", data);

      //   axios.post("uploader", data, {
      //     headers: {
      //       "Content-Type": "multipart/form-data",
      //     },
      //   }).then(function(res){
      //       console.log(res.data);
      //    });
    },
  },
};
</script>
<style scoped>
</style>
