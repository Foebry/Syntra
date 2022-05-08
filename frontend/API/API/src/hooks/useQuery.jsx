import { useEffect, useState } from "react";
import axios from "axios";

const useQuery = () => {
  const [loading, setLoading] = useState(false);
  const [data, setData] = useState();
  const [error, setError] = useState();

  useEffect(() => {
    (async () => {
      try {
        setLoading(true);
        setError(false);
        const response = await axios.get(
          "http://localhost:3030/api/v1/products"
        );
        console.log("response", response);
        setError(false);
        setLoading(false);
        setData(response.data);
      } catch (error) {
        setLoading(false);
        setError(error);
      }
    })();
  }, []);
  return { loading, data, error };
};

export default useQuery;
