<template>
  <app-layout>
    <template #header>
      <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2> -->
    </template>

    <div class="pt-6 pb-12 bg-gray-300">
      <div id="card" class="">
        <h2 class="text-center font-serif uppercase text-4xl xl:text-5xl">
          My Info({{ role }})
        </h2>
        <!-- container for all cards -->
        <div class="container w-100 lg:w-4/5 mx-auto flex flex-col">
          <!-- card -->
          <div
            class="flex flex-col md:flex-row overflow-hidden bg-white rounded-lg shadow-xl mt-4 w-100 mx-2"
          >
            <!-- media -->
            <div class="h-64 w-auto md:w-1/2">
              <img
                class="h-full w-full object-cover object-center"
                :src="route('images', user.profile_photo_path)"
                alt=""
                v-if="user.profile_photo_path"
              />
              <img
                class="inset-0 h-full w-full object-cover object-center"
                src="https://user-images.githubusercontent.com/194400/49531010-48dad180-f8b1-11e8-8d89-1e61320e1d82.png"
                v-else
              />
            </div>
            <!-- content -->
            <div
              class="w-full py-4 px-6 text-gray-800 flex flex-col justify-between"
            >
              <h3 class="font-semibold text-lg leading-tight truncate">
                {{ user.name }}
              </h3>
              <p class="mt-2">
                {{ user.email }}
              </p>
              <div
                class="flex w-full items-center justify-center bg-grey-lighter"
              >
                <label
                  class="w-64 flex flex-col items-center px-4 py-6 bg-blue-800 text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white"
                >
                  <svg
                    class="w-8 h-8"
                    fill="white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"
                    />
                  </svg>
                  <span class="mt-2 text-base leading-normal text-white"
                    >Select a file</span
                  >
                  <input type="file" class="hidden" ref="photo" @change="upload"/>
                </label>
              </div>
            </div>
          </div>
          <!--/ card-->
        </div>
        <!--/ flex-->
      </div>
    </div>

    <div>
      <div
        class="bg-white rounded shadow border p-6 w-100"
        v-if="role == 'super-admin'"
      >
        <h5 class="text-3xl font-bold mb-4 mt-0 text-center">Users</h5>
        <table class="min-w-full table-auto">
          <thead class="justify-between">
            <tr class="bg-gray-800">
              <th class="px-16 py-2">
                <span class="text-gray-300 text-center"></span>
              </th>
              <th class="px-16 py-2">
                <span class="text-gray-300 text-center">Name</span>
              </th>
              <th class="px-16 py-2">
                <span class="text-gray-300">Simulation</span>
              </th>
              <th class="px-16 py-2">
                <span class="text-gray-300">Date</span>
              </th>

              <th class="px-16 py-2">
                <span class="text-gray-300">Time</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-gray-200">
            <tr
              v-for="u in users"
              class="bg-white border-4 border-gray-200"
              :key="u.id"
            >
              <td class="px-16 py-2 flex flex-row items-center">
                <img
                  class="h-8 w-8 rounded-full object-cover"
                  :src="route('images', u.profile_photo_path)"
                  alt=""
                  v-if="u.profile_photo_path"
                />
                <img
                  class="h-8 w-8 rounded-full object-cover"
                  src="http://www.landscapingbydesign.com.au/wp-content/uploads/2018/11/img-person-placeholder.jpg"
                  alt=""
                  v-else
                />
              </td>
              <td>
                <span class="text-center ml-2 font-semibold">{{ u.name }}</span>
              </td>
              <td class="px-16 py-2">
                <inertia-link
                  :href="route('impersonate', u.id)"
                  as="button"
                  type="button"
                  class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black"
                  >Simulate</inertia-link
                >
              </td>
              <td class="px-16 py-2">
                <span>{{ u.created_at | get_date_time(true) }}</span>
              </td>
              <td class="px-16 py-2">
                <span>{{ u.created_at | get_date_time }}</span>
              </td>
            </tr>
          </tbody>
        </table>
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
    admin: Object,
  },
  mounted: function () {
  },
  methods: {
    upload() {
      var data = new FormData();
      var photo = this.$refs.photo.files[0];
      data.append("photo", photo || "");
      this.$inertia.post("/uploader", data);

    },
  },
  filters: {
    get_date_time: function (value, flag = false) {
      let date = new Date(Date.parse(value));
      return flag ? date.toDateString() : date.toTimeString();
    },
  },
};
</script>
<style scoped>
</style>
