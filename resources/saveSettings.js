const { ref } = Vue;

export const loading = ref(false);

export const recentlySuccessful = ref(false);

export const recentlyError = ref(false);

export const errorMessage = ref('');

export const saveSettings = async (state) => {

  loading.value = true;

  const response = await fetch("/wp-json/v1/sigmie/save-settings", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-WP-Nonce": wpApiSettings.nonce,
    },
    body: JSON.stringify(state),
  });

  loading.value = false;

  const data = await response.json();

  if (!response.ok) {

    errorMessage.value = data.message;

    recentlyError.value = true;

    setTimeout(() => {
      recentlyError.value = false;
    }, 1300);

  } else {

    recentlySuccessful.value = true;

    setTimeout(() => {
      recentlySuccessful.value = false;
    }, 1300);

  }
};
