window.react = function react(postId, type, btn) {
    const parent = btn.closest('.card-body');
    if (!parent) return;

    const likeButton = parent.querySelector('button[onclick*="like"]');
    const dislikeButton = parent.querySelector('button[onclick*="dislike"]');
    const likeCount = parent.querySelector('.like-count');
    const dislikeCount = parent.querySelector('.dislike-count');
    
    // IMMEDIATE: Reset + optimistic update
    [likeButton, dislikeButton].forEach(b => {
        if (b) {
            b.classList.remove('btn-primary', 'btn-danger');
            b.classList.add('btn-outline-primary', 'btn-outline-danger');
            b.disabled = true;
        }
    });
    
    // Optimistic: highlight clicked button
    if (type === 'like' && likeButton) {
        likeButton.classList.remove('btn-outline-primary');
        likeButton.classList.add('btn-primary');
    }
    if (type === 'dislike' && dislikeButton) {
        dislikeButton.classList.remove('btn-outline-danger');
        dislikeButton.classList.add('btn-danger');
    }
    
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
fetch(`/posts/${postId}/react/${type}`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': token, 'Accept': 'application/json'}
    })
    .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
    })
    .then(data => {
        // SERVER CONFIRMS - final authority
        if (likeCount) likeCount.textContent = data.likes;
        if (dislikeCount) dislikeCount.textContent = data.dislikes;

if(type === 'like') {
        const popup = btn.querySelector('.like-popup');
        if(popup) {
            popup.style.opacity = '1';
            popup.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                popup.style.opacity = '0';
                popup.style.transform = 'translateY(0)';
            }, 500);
        }
    }
        
        // Reset then apply server truth
        if (likeButton) {
            likeButton.disabled = false;
            likeButton.className = data.userReaction === 'like' ? 
                'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary';
        }
        if (dislikeButton) {
            dislikeButton.disabled = false;
            dislikeButton.className = data.userReaction === 'dislike' ? 
                'btn btn-sm btn-danger' : 'btn btn-sm btn-outline-danger';
        }
    })
    .catch(err => {
        console.error('Error:', err);
        // REVERT on error
        location.reload();
    });
};
