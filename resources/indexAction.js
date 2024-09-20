const { ref } = Vue;

export const loading = ref(false);

export const recentlySuccessful = ref(false);

export const recentlyError = ref(false);

export const errorMessage = ref('');

export const indexAction = async (action) => {

  loading.value = true;

  const response = await fetch("/wp-json/v1/sigmie/" + action, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-WP-Nonce": wpApiSettings.nonce,
    },
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

  return data.data;
};
