import axios from 'axios'

export const useApi = () => {
  const config = useRuntimeConfig();

  const service = axios.create({
    baseURL: config.public.apiBase
  });
  return service;
};
