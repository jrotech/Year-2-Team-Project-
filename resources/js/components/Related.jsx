import React from 'react'
import { Stars } from "./Stars";


export default function Related({img_url, name, price, description, rating, id }){
  return (
    <div className="max-w-[400px] flex flex-col gap-y-4 bg-white hover:bg-main-bg transition-all duration-300 py-4 px-8 rounded-md">
      <img alt="" src={img_url} className="my-8" />
      <h1 className="text-4xl font-bold">{name}</h1>
      <h4 className="text-lg">{description}</h4>
      <div className="flex items-center justify-center w-full my-6">
	<Stars rating={rating}/>
      </div>
      <div className="flex justify-between">
	<h3 className="text-2xl font-bold">{price}</h3>
	<button className="bg-main-primary outline-none text-white px-4 py-2 rounded-md"><a href={`/shop/product/${id}`}>See More</a></button>
      </div>
    </div>
  )
}
