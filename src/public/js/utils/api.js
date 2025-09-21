export async function apiRequest(endpoint, options = {}) {
  const response = await fetch(`/api/${endpoint}`, {
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    ...options,
  });

  const data = await response.json();
  if (!response.ok) {
    const err = new Error(`API error: ${response.status}`);
    err.details = data;
    throw err;
  }
  return response;
}
