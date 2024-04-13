const { ref } = Vue;

export const loading = ref(false);

export const recentlySuccessful = ref(false);

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

  recentlySuccessful.value = true;

  setTimeout(() => {
    recentlySuccessful.value = false;
  }, 1300);

  if (!response.ok) {
    throw new Error("Network response was not ok");
  }

  const data = await response.json();
};
