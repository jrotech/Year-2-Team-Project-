import React from 'react';
import { createRoot } from 'react-dom/client';
import { useEffect, useState } from 'react';

import Images from './Image';
import { Flex, MantineProvider, Stack } from '@mantine/core';
import { ModalsProvider } from '@mantine/modals';
import { theme } from '../mantine';
import Info from './Info';
import Footer from './Footer';
import Feedback from './Feedback';

function Product(props) {
	const path = window.location.pathname; // Get the current path
	const id = path.substring(path.lastIndexOf('/') + 1); // Extract everything after the last '/'
	console.log(id); // Logs the ID (last two characters)
	const [product, setProduct] = useState(null);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		// Fetch product details from the Laravel API
		fetch(`/api/products/${id}`)
			.then((response) => {
				if (!response.ok) {
					throw new Error('Failed to fetch product');
				}
				return response.json();
			})
			.then((data) => {
				setProduct(data);
				setLoading(false);
			})
			.catch((error) => {
				console.error('Error fetching product:', error);
				setLoading(false);
			});
	}, [id]);

	if (loading) {
		return <div>Loading...</div>;
	}

	if (!product) {
		return <div>Product not found.</div>;
	}
	return (
		<MantineProvider theme={theme}>
			<Stack className="bg-main-bg py-24 px-16 justify-center w-screen">
				<Flex gap="50" wrap="wrap" justify="center">
					{console.log(product.images)}
					<Images images={product.images} />
					<ModalsProvider>
						<Info
							productName={product.name}
							inStock={product.in_stock}
							rating={3} // Replace with actual rating if available
							price={product.price}
							description={product.description}
							id={id}
						/>
					</ModalsProvider>
				</Flex>
				<Footer description="Detailed information about the product." />
				<Feedback />
			</Stack>
		</MantineProvider>
	)
}

export default Product;

const rootElement = document.getElementById('product')
const root = createRoot(rootElement);

root.render(<Product {...Object.assign({}, rootElement.dataset)} />);


