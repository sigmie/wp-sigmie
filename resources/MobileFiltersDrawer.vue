<template>
  <TransitionRoot as="template" :show="open">
    <Dialog
      as="div"
      class="sgm-relative sgm-z-30"
      @close="() => $emit('close')"
    >
      <div class="sgm-fixed sgm-inset-0" />

      <div class="sgm-fixed sgm-inset-0 sgm-overflow-hidden">
        <div class="sgm-absolute sgm-inset-0 sgm-overflow-hidden">
          <div
            class="sgm-pointer-events-none sgm-fixed sgm-inset-y-0 sgm-right-0 sgm-flex sgm-max-w-full"
          >
            <TransitionChild
              as="template"
              enter="sgm-duration-150 sgm-ease-out"
              enter-from="sgm-opacity-0"
              enter-to="sgm-opacity-100"
              leave="sgm-duration-200 sgm-ease-in"
              leave-from="sgm-opacity-100"
              leave-to="sgm-opacity-0"
            >
              <div
                class="sgm-fixed sgm-inset-0 sgm-bg-black sgm-bg-opacity-25"
              />
            </TransitionChild>

            <div
              class="sgm-p-3 sgm-z-50 sgm-rounded-xl sgm-h-full sgm-overflow-hidden"
            >
              <TransitionChild
                as="template"
                enter="sgm-transform sgm-transition sgm-ease-in-out sgm-duration-200 sm:sgm-duration-500"
                enter-from="sgm-translate-x-full"
                enter-to="sgm-translate-x-0"
                leave="sgm-transform sgm-transition sgm-ease-in-out sgm-duration-300 sm:sgm-duration-600"
                leave-from="sgm-translate-x-0"
                leave-to="sgm-translate-x-full"
              >
                <DialogPanel
                  class="sgm-pointer-events-auto sgm-h-full sgm-flex sgm-flex-row sgm-justify-end"
                >
                  <div
                    class="sgm-flex sgm-h-full sgm-flex-col sgm-justify-start sgm-rounded-md sgm-overflow-y-scroll sgm-bg-white sgm-shadow-xl"
                  >
                    <div class="sgm-px-4 sgm-py-3 sm:sgm-px-6 sgm-border-b">
                      <div
                        class="sgm-flex sgm-flex-row sgm-items-center sgm-justify-center sgm-relative"
                      >
                        <span
                          class="sgm-text-black sgm-text-2xl lg:sgm-text-base sgm-font-bold sgm-leading-7"
                        >
                          {{ title }}
                        </span>
                        <div class="sgm-absolute sgm-top-1 sgm-right-0">
                          <button
                            type="button"
                            class="sgm-rounded-md sgm-bg-white sgm-text-zinc-400 sgm-hover-text-zinc-500 sgm-focus:outline-none sgm-focus-visible:outline sgm-focus-visible:-outline-offset-1 sgm-focus-visible:outline-2 sgm-focus-visible:outline-zinc-400 sgm-outline-none sgm-border-0"
                            @click="() => $emit('close')"
                          >
                            <span class="sgm-sr-only">Close panel</span>
                            <XMarkIcon
                              class="sgm-h-6 sgm-w-6 sgm-border-0 -sgm-mr-2"
                              aria-hidden="true"
                            />
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- Main -->
                    <div
                      class="sgm-w-[480px] sgm-h-full sgm-flex sgm-flex-col sgm-justify-between"
                    >
                      <div>
                        <slot></slot>
                      </div>

                      <div class="sgm-absolute sgm-bottom-0 sgm-bg-white sgm-w-full sgm-h-20">
                        <div class="sgm-py-4 sgm-px-4">
                          <slot name="actions"></slot>
                        </div>
                      </div>
                    </div>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import XMarkIcon from "./XIcon.vue";

const props = defineProps(["open", "title"]);
const emit = defineEmits(["close"]);
</script>
