<template>
  <form class="sgm-mx-auto sgm-max-w-5xl">
    <div class="sgm-space-y-12">
      <div
        class="sgm-grid sgm-grid-cols-1 sgm-gap-x-8 sgm-gap-y-10 sgm-border-b sgm-border-gray-900/10 sgm-pb-12 md:sgm-grid-cols-3"
      >
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            Profile
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            This information will be displayed publicly so be careful what you
            share.
          </p>
        </div>

        <div
          class="sgm-grid sgm-max-w-2xl sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8 sm:sgm-grid-cols-6 md:sgm-col-span-2"
        >
          <div class="sm:sgm-col-span-4">
            <label
              for="website"
              class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
              >Website</label
            >
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label for="username">Username</label>
                <InputText
                  id="username"
                  v-model="value"
                  aria-describedby="username-help"
                />
                <small id="username-help"
                  >Enter your username to reset your password.</small
                >
              </div>
            </div>
          </div>

          <div class="sgm-col-span-full">
            <label
              for="about"
              class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
              >About</label
            >
            <div class="sgm-mt-2">
              <Textarea rows="5" cols="30" />
            </div>
            <p class="sgm-mt-3 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
              Write a few sentences about yourself.
            </p>
          </div>
        </div>
      </div>

      <div
        class="sgm-grid sgm-grid-cols-1 sgm-gap-x-8 sgm-gap-y-10 sgm-border-b sgm-border-gray-900/10 sgm-pb-12 md:sgm-grid-cols-3"
      >
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            Personal Information
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Use a permanent address where you can receive mail.
          </p>
        </div>

        <div
          class="sgm-grid sgm-max-w-2xl sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8 sm:sgm-grid-cols-6 md:sgm-col-span-2"
        >
          <div class="sm:sgm-col-span-3">
            <label
              for="first-name"
              class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
              >First name</label
            >
            <div class="sgm-mt-2">
              <input
                type="text"
                name="first-name"
                id="first-name"
                autocomplete="given-name"
                class="sgm-block sgm-w-full sgm-rounded-md sgm-border-0 sgm-py-1.5 sgm-text-gray-900 sgm-shadow-sm sgm-ring-1 sgm-ring-inset sgm-ring-gray-300 sgm-placeholder:text-gray-400 sgm-focus:ring-2 sgm-focus:ring-inset sgm-focus:ring-indigo-600 sm:sgm-text-sm sm:sgm-leading-6"
              />
            </div>
          </div>

          <div class="sm:sgm-col-span-3">
            <label
              for="last-name"
              class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
              >Last name</label
            >
            <div class="sgm-mt-2">
              <input
                type="text"
                name="last-name"
                id="last-name"
                autocomplete="family-name"
                class="sgm-block sgm-w-full sgm-rounded-md sgm-border-0 sgm-py-1.5 sgm-text-gray-900 sgm-shadow-sm sgm-ring-1 sgm-ring-inset sgm-ring-gray-300 sgm-placeholder:text-gray-400 sgm-focus:ring-2 sgm-focus:ring-inset sgm-focus:ring-indigo-600 sm:sgm-text-sm sm:sgm-leading-6"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { PhotoIcon, UserCircleIcon } from "@heroicons/vue/24/solid";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
</script>
