<template>
  <div class="sgm-flex sgm-flex-col sgm-space-y-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h2
          class="sgm-text-lg sgm-font-semibold sgm-leading-6 sgm-text-gray-900"
        >
          Filterable Attributes
        </h2>
        <p class="sgm-mt-2 sgm-text-sm sgm-text-gray-700">
          This section allows you to customize the attributes that can be used
          for filtering and their display order.
        </p>
      </div>
    </div>
    <div class="sgm-flex sgm-flex-col sgm-gap-2">
      <PickList
        v-model="index.attributes"
        listStyle="height:342px"
        dataKey="id"
        breakpoint="1400px"
      >
        <template #sourceheader> Attributes</template>
        <template #targetheader> Filterable </template>
        <template #item="slotProps">
          <div
            class="sgm-flex sgm-flex-wrap sgm-p-2 sgm-align-items-center sgm-gap-2"
          >
            <span class="sgm-font-bold">{{ slotProps.item.name }}</span>
            <span>({{ slotProps.item.slug }})</span>
            <!-- <span class="font-bold">{{ slotProps.item.id }}</span> -->
          </div>
        </template>
      </PickList>

      <div class="sm:flex-auto sgm-mt-4">
        <h2
          class="sgm-text-lg sgm-font-semibold sgm-leading-6 sgm-text-gray-900"
        >
          Attribute Types
        </h2>
        <p class="sgm-mt-2 sgm-text-sm sgm-text-gray-700">
          This is where you can define the type of each attribute and configure
          its settings.
        </p>
      </div>
      <div
        class="sgm-h-24 sgm-border sgm-rounded-lg sgm-bg-gray-100 sgm-outline sgm-outline-gray-300 sgm-flex sgm-flex-row sgm-items-center sgm-justify-center sgm-w-full"
        v-if="index.attributes[1]?.length === 0"
      >
        <div class="sgm-text-base sgm-text-gray-500">
          No filterable attributes selcted.
        </div>
      </div>

      <DataTable
        v-else
        :expandedRows="[]"
        :value="index.attributes[1]"
        dataKey="id"
        tableStyle="min-width: 60rem"
      >
        <Column expander style="width: 5rem" />
        <Column field="name" header="Name"></Column>
        <Column field="type" header="Type"></Column>

        <template #expansion="slotProps">
          <div class="sgm-px-3 sgm-flex sgm-flex-col sgm-space-y-4">
            <h4>Settings for {{ slotProps.data.name }} attribute.</h4>

            <div
              class="sgm-flex sgm-flex-row sgm-items-end sgm-space-x-10 sgm-flex-wrap"
            >
              <div>
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                  for="sigmie_search_field_text"
                  >Type</label
                >
                <Dropdown
                  :modelValue="index.attributes[1][slotProps.index].type"
                  @update:modelValue="
                    (value) => onModelUpdate(value, slotProps.index)
                  "
                  optionLabel="label"
                  optionValue="value"
                  :options="[
                    { label: 'Text', value: 'text' },
                    { label: 'Color', value: 'color' },
                    { label: 'Number', value: 'number' },
                    { label: 'Select Button', value: 'selectbutton' },
                  ]"
                ></Dropdown>
              </div>

              <div>
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                  for="sigmie_search_field_text"
                  >Label</label
                >
                <InputText
                  v-model="index.attributes[1][slotProps.index].label"
                ></InputText>
              </div>

              <div>
                <SelectButton
                  optionLabel="label"
                  optionValue="value"
                  :options="[
                    { label: 'expanded', value: true },
                    { label: 'collapsed', value: false },
                  ]"
                  v-model="index.attributes[1][slotProps.index].expanded"
                ></SelectButton>
              </div>

              <div
                v-if="index.attributes[1][slotProps.index].type === 'number'"
              >
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                  for="sigmie_search_field_text"
                  >Slider Step</label
                >
                <InputText
                  v-model="index.attributes[1][slotProps.index].step"
                ></InputText>
              </div>
            </div>

            <DataTableEditable
              v-if="
                index.attributes[1][slotProps.index].type === 'selectbutton'
              "
              :value="index.attributes[1][slotProps.index].values"
            >
              <Column field="label" header="Value"> </Column>
            </DataTableEditable>

            <DataTableEditable
              @rowReorder="
                (e) => (index.attributes[1][slotProps.index].values = e.value)
              "
              v-if="index.attributes[1][slotProps.index].type === 'text'"
              :value="index.attributes[1][slotProps.index].values"
            >
              <Column
                rowReorder
                headerStyle="width: 3rem"
                :reorderableColumn="false"
              />
              <Column field="label" header="Value"> </Column>
            </DataTableEditable>

            <DataTableEditable
              v-if="index.attributes[1][slotProps.index].type === 'number'"
              :value="index.attributes[1][slotProps.index].values"
            >
              <Column field="label" header="Value"> </Column>
            </DataTableEditable>

            <DataTableEditable
              v-if="index.attributes[1][slotProps.index].type === 'color'"
              :value="index.attributes[1][slotProps.index].values"
              @rowReorder="
                (e) => (index.attributes[1][slotProps.index].values = e.value)
              "
            >
              <Column
                rowReorder
                headerStyle="width: 3rem"
                :reorderableColumn="false"
              />
              <Column field="label" header="Value"> </Column>
              <Column header="Num. of Colors">
                <template #body="slotPropsBlah">
                  <div
                    class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-2"
                  >
                    <Dropdown
                      class="sgm-max-w-[120px] sgm-w-full"
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].number_of_colors
                      "
                      optionLabel="label"
                      optionValue="value"
                      :options="[
                        { label: 'One', value: 1 },
                        { label: 'Two', value: 2 },
                        { label: 'Three', value: 3 },
                      ]"
                    ></Dropdown>
                  </div>
                </template>
              </Column>
              <Column field="image" header="Color 1">
                <template #body="slotPropsBlah">
                  <div
                    class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-2"
                  >
                    <ColorPickerOne
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_1
                      "
                      inputId="cp-hex_1"
                      format="hex"
                      class="mb-3"
                    />

                    <InputText
                      class="sgm-max-w-[100px]"
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_1
                      "
                    ></InputText>
                  </div>
                </template>
              </Column>
              <Column field="image" header="Color 2">
                <template #body="slotPropsBlah">
                  <div
                    v-if="
                      index.attributes[1][slotProps.index].values[
                        slotPropsBlah.index
                      ].number_of_colors > 1
                    "
                    class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-2"
                  >
                    <ColorPickerTwo
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_2
                      "
                      inputId="cp-hex_2"
                      format="hex"
                      class="mb-3"
                    />
                    <InputText
                      class="sgm-max-w-[100px]"
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_2
                      "
                    ></InputText>
                  </div>
                </template>
              </Column>

              <Column field="image" header="Color 3">
                <template #body="slotPropsBlah">
                  <div
                    v-if="
                      index.attributes[1][slotProps.index].values[
                        slotPropsBlah.index
                      ].number_of_colors > 2
                    "
                    class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-2"
                  >
                    <ColorPickerThree
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_3
                      "
                      inputId="cp-hex_3"
                      format="hex"
                      class="mb-3"
                    />

                    <InputText
                      class="sgm-max-w-[100px]"
                      v-model="
                        index.attributes[1][slotProps.index].values[
                          slotPropsBlah.index
                        ].color_hex_3
                      "
                    ></InputText>
                  </div>
                </template>
              </Column>
            </DataTableEditable>
          </div>
        </template>
      </DataTable>
    </div>

    <div
      class="sgm-flex sgm-space-y-3 sm:sgm-space-y-0 sm:sgm-space-x-3 sgm-flex-col sm:sgm-flex-row sgm-justify-end sgm-w-full"
    >
      <div class="sgm-h-[30px]">
        <InlineMessage severity="success" v-if="recentlySuccessful"
          >Your changes have been saved!</InlineMessage
        >
        <InlineMessage severity="error" v-if="recentlyError">
          Oops! Something went wrong.
        </InlineMessage>
      </div>
      <Button
        size="small"
        :loading="loading"
        :label="recentlySuccessful ? 'Settings Saved' : 'Save Settings'"
        @click="onSaveSettings"
      >
      </Button>
    </div>
  </div>
</template>

<script setup>
const { reactive, ref, onMounted } = Vue;

import {
  saveSettings,
  loading,
  recentlySuccessful,
  recentlyError,
  errorMessage,
} from "./saveSettings.js";

const Button = primevue.button;
const Dropdown = primevue.dropdown;
const Multiselect = primevue.multiselect;
const DataTable = primevue.datatable;
const DataTableEditable = primevue.datatable;
const Column = primevue.column;
const PickList = primevue.picklist;
const Divider = primevue.divider;
const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const ColorPickerOne = primevue.colorpicker;
const ColorPickerTwo = primevue.colorpicker;
const ColorPickerThree = primevue.colorpicker;
const InlineMessage = primevue.inlinemessage;
const SelectButton = primevue.selectbutton;

const onSaveSettings = () => {
  const state = { filterable_attributes: index.attributes[1] };

  saveSettings(state);
};

onMounted(() => {
  index.attributes = [props.attributes, props.filterableAttributes];

  let types = {};

  props.filterableAttributes.forEach((attribute) => {
    types[attribute.slug] = attribute.type;
  });

  props.attributes.forEach((attribute) => {
    types[attribute.slug] = attribute.type;
  });

  attributeTypes.value = types;
});
const columns = ref([{ field: "name", header: "Name" }]);

const props = defineProps(["attributes", "filterableAttributes"]);

const index = reactive({
  attributes: [],
});

const attributeTypes = ref([]);

const onModelUpdate = (value, indix) => {
  index.attributes[1][indix].type = value;
};
</script>
