window.react = function react(postId, type, btn) {
    fetch(`/posts/${postId}/${type}`,{
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        const parent = btn.closest('.card-body');
        parent.querySelector('.like-count').textContent = data.likes;
        parent.querySelector('.dislike-count').textContent = data.dislikes;
        
        const likeButton = parent.querySelector('button:nth-child(1)');
        const distlikeButton = parent.querySelector('button:nth-child(2)');

        likeButton.classList.remove('btn-primary');
        likeButton.classList.add('btn-outline primary');
        distlikeButton.classList.remove('btn-danger');
        distlikeButton.classList.add('btn-outline-danger');

        if(data.userReaction === 'like') {
            likeButton.classList.remove('btn-outline primary');
            likeButton.classList.add('btn-primary');
        }
        if(data.userReaction === 'dislike') {
            distlikeButton.classList.remove('btn-outline-danger');
            distlikeButton.classList.add('btn-danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
