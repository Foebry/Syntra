import React from "react";

const index = () => {
  const products = axios("http://localhost:8080/api/v1/products");
  return (
    <div>
      <ul>
        {products.map(({ id, name, image }) => (
          <li key={id} style={{ display: "flex" }}>
            <h1>{name}</h1>
            <img src={`images/${image}`} />
          </li>
        ))}
      </ul>
    </div>
  );
};

export default index;
