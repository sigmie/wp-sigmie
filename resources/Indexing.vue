<template>
  <div class="sgm-px-4 sm:sgm-px-6 sgm-lg:px-8 sgm-max-w-5xl sgm-mx-auto">
    <div class="sm:sgm-sgm-flex sm:sgm-items-center">
      <div class="sm:sgm-flex-auto">
        <h1
          class="sgm-text-base sgm-font-semibold sgm-leading-6 sgm-text-gray-900"
        >
          Users
        </h1>
        <p class="sgm-mt-2 sgm-text-sm sgm-text-gray-700">
          A list of all the users in your account including their name, title,
          email and role.
        </p>
      </div>
      <div class="sgm-mt-4 sm:sgm-ml-16 sm:sgm-mt-0 sm:sgm-flex-none">
        <button
          type="button"
          class="sgm-block sgm-rounded-md sgm-bg-indigo-600 sgm-px-3 sgm-py-2 sgm-text-center sgm-text-sm sgm-font-semibold sgm-text-white sgm-shadow-sm sgm-hover:bg-indigo-500 sgm-focus-visible:outline sgm-focus-visible:outline-2 sgm-focus-visible:outline-offset-2 sgm-focus-visible:outline-indigo-600"
        >
          Add user
        </button>
      </div>
    </div>
    <div class="sgm-mt-8 sgm-flow-root">
      <div
        class="sgm--mx-4 sgm--my-2 sgm-overflow-x-auto sm:sgm--mx-6 sgm-lg:-mx-8"
      >
        <div
          class="sgm-inline-block sgm-min-w-full sgm-py-2 sgm-align-middle sm:sgm-px-6 sgm-lg:px-8"
        >
          <table class="sgm-min-w-full sgm-divide-y sgm-divide-gray-300">
            <thead>
              <tr>
                <th
                  scope="col"
                  class="sgm-py-3.5 sgm-pl-4 sgm-pr-3 sgm-text-left sgm-text-sm sgm-font-semibold sgm-text-gray-900 sm:sgm-pl-0"
                >
                 id 
                </th>
                <th
                  scope="col"
                  class="sgm-px-3 sgm-py-3.5 sgm-text-left sgm-text-sm sgm-font-semibold sgm-text-gray-900"
                >
                label
                </th>
                <th
                  scope="col"
                  class="sgm-px-3 sgm-py-3.5 sgm-text-left sgm-text-sm sgm-font-semibold sgm-text-gray-900"
                >
                 name 
                </th>
                <th
                  scope="col"
                  class="sgm-px-3 sgm-py-3.5 sgm-text-left sgm-text-sm sgm-font-semibold sgm-text-gray-900"
                >
                 type 
                </th>
                <th
                  scope="col"
                  class="sgm-relative sgm-py-3.5 sgm-pl-3 sgm-pr-4 sm:sgm-pr-0"
                >
                  <span class="sgm-sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="sgm-divide-y sgm-divide-gray-200">
              <tr v-for="attribute in attributes" :key="attribute">
                <td
                  class="sgm-whitespace-nowrap sgm-py-4 sgm-pl-4 sgm-pr-3 sgm-text-sm sgm-font-medium sgm-text-gray-900 sm:sgm-pl-0"
                >
                  {{ attribute.attribute_name }}
                </td>
                <td
                  class="sgm-whitespace-nowrap sgm-px-3 sgm-py-4 sgm-text-sm sgm-text-gray-500"
                >
                  {{ attribute.attribute_label }}
                </td>
                <td
                  class="sgm-whitespace-nowrap sgm-px-3 sgm-py-4 sgm-text-sm sgm-text-gray-500"
                >
                  {{ attribute.attribute_type }}
                </td>
                <td
                  class="sgm-whitespace-nowrap sgm-px-3 sgm-py-4 sgm-text-sm sgm-text-gray-500"
                >
                  {{ attribute.attribute_id }}
                </td>
                <td
                  class="sgm-relative sgm-whitespace-nowrap sgm-py-4 sgm-pl-3 sgm-pr-4 sgm-text-right sgm-text-sm sgm-font-medium sm:sgm-pr-0"
                >
                  <a
                    href="#"
                    class="sgm-text-indigo-600 sgm-hover:text-indigo-900"
                    >Edit<span class="sgm-sr-only">,</span></a
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(["attributes"]);

const people = [
  {
    name: "Lindsay Walton",
    title: "Front-end Developer",
    email: "lindsay.walton@example.com",
    role: "Member",
  },
  // More people...
];
</script>
