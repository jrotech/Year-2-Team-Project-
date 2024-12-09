/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react'
import { Stars } from "./Stars";


export default function Related({ img_url, name, price, description, rating, id }) {
  return (
    <div className="w-[400px] h-[500px] flex flex-col gap-y-4 bg-white hover:bg-main-bg transition-all duration-300 py-4 px-8 rounded-md">
      <img alt="" src={img_url} className="h-[150px] object-contain my-4" />
      <h1 className="text-2xl font-bold">{name}</h1>
      <h4 className="text-sm text-gray-600">{description}</h4>
      <div className="flex items-center justify-center w-full my-4">
        <Stars rating={rating} />
      </div>

      {/* Add a spacer to push the button to the bottom */}
      <div className="flex-grow"></div>

      <div className="flex justify-between items-center">
        <h3 className="text-xl font-bold">£{price}</h3>
        <button className="bg-main-primary outline-none text-white px-4 py-2 rounded-md">
          <a href={`/shop/product/${id}`}>See More</a>
        </button>
      </div>
    </div>

  )
}
