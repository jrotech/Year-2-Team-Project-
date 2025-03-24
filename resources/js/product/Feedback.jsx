import React from 'react'
import { Stack, Flex, Title, Text, Button, Rating } from '@mantine/core'
import { Stars } from '../components/Stars'

export default function Feedback({ productId }) {
    const [rating, setRating] = React.useState(0);
    const [comment, setComment] = React.useState('');
    const [submitting, setSubmitting] = React.useState(false);
    const [message, setMessage] = React.useState('');
    const [reviews, setReviews] = React.useState([]);
    const [averageRating, setAverageRating] = React.useState(0);

    // Fetch reviews when component mounts or after submission
    const fetchReviews = () => {
        fetch(`/products/${productId}/reviews`)
            .then(response => response.json())
            .then(data => {
                if (data.reviews && data.reviews.data) {
                    setReviews(data.reviews.data);
                }
                setAverageRating(data.average_rating || 0);
            })
            .catch(error => {
                console.error('Error fetching reviews:', error);
            });
    };

    // Fetch reviews when component mounts
    React.useEffect(() => {
        if (productId) {
            fetchReviews();
        }
    }, [productId]);

    const handleSubmit = () => {
        if (!productId || rating === 0) {
            setMessage('Please select a rating');
            return;
        }

        setSubmitting(true);
        setMessage('Submitting review...');

        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || ''
            },
            body: JSON.stringify({
                product_id: productId,
                rating: rating,
                comment: comment
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setMessage('Review submitted successfully!');
                    setRating(0);
                    setComment('');
                    // Fetch reviews again after successful submission
                    fetchReviews();
                } else {
                    setMessage(data.message || 'Failed to submit review');
                }
            })
            .catch(error => {
                console.error('Error submitting review:', error);
                setMessage('Error submitting review. Please try again.');
            })
            .finally(() => {
                setSubmitting(false);
            });
    };

    return (
        <Stack>
            <Title>Feedback</Title>
            <Flex>
                <Title order={3}>Overall rating</Title>
                <Stars rating={Math.round(averageRating)} />
            </Flex>

            <Stack className="max-w-[400px]">
                <Title order={2}>Leave your feedback</Title>
                {message && <Text color={message.includes('success') ? 'green' : 'red'}>{message}</Text>}
                <Stack gap="20">
                    <Rating
                        value={rating}
                        onChange={setRating}
                        size="xl"
                        color="#FFE100"
                    />
                    <textarea
                        value={comment}
                        onChange={(e) => setComment(e.target.value)}
                        placeholder="Please leave your feedback here"
                        className="bg-white rounded-md min-h-52 w-full p-2"
                        style={{ minHeight: '100px' }}
                    />
                    <Button
                        className="!rounded-md"
                        onClick={handleSubmit}
                        disabled={submitting || rating === 0}
                    >
                        {submitting ? 'Submitting...' : 'Submit'}
                    </Button>
                </Stack>
            </Stack>

            {/* Display reviews from database */}
            {reviews.length > 0 ? (
                <Stack spacing="md" mt="xl">
                    <Title order={3}>Customer Reviews</Title>
                    {reviews.map(review => (
                        <FeebackCard
                            key={review.id}
                            userName={review.customer ? review.customer.customer_name : 'Anonymous'}
                            rating={review.rating}
                            comment={review.comment}
                        />
                    ))}
                </Stack>
            ) : (
                <Text color="dimmed" mt="xl">No reviews yet. Be the first to leave feedback!</Text>
            )}
        </Stack>
    );
}

function FeebackCard({userName, rating, comment}) {
    const [showMore, setShowMore] = React.useState(false);
    return (
        <Stack className="max-w-[800px] bg-white rounded-md pt-8 px-6">
            <Flex jusify="center" align="center" gap="50" className="flex-col md:flex-row">
                <Flex gap="20" align="center">
                    <Title order={2}>{userName}</Title>
                </Flex>
                <Stars rating={rating} />
            </Flex>
            <Text lineClamp={showMore ? 0 : 5}>{comment}</Text>
            {comment && comment.length > 300 && (
                <Text align="right" fs="italic" td="underline" className="cursor-pointer" onClick={() => setShowMore(!showMore)}>
                    {showMore ? 'Show less' : 'Show more'}
                </Text>
            )}
        </Stack>
    );
}
