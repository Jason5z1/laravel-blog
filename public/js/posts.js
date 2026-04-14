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

if(data.userReaction === 'like') {
    spawnPlusOne(btn);
    setTimeout(() => spawnHeart(btn), 200);
 }
        const likeIcon = parent.querySelector('.like-icon');
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

function spawnHeart(btn) {
    const popup = document.createElement('span');
    
    // 這裡一定要改成新的 Class 名字！
    popup.className = 'pure-floating-heart';
    popup.innerHTML = '💖';
    
    // 獲取按鈕在畫面上的絕對位置
    const rect = btn.getBoundingClientRect();
    popup.style.left = rect.left + 'px';
    popup.style.top = rect.top + 'px';
    
    document.body.appendChild(popup);
    
    // 1.5秒後移除
    setTimeout(() => popup.remove(), 1500);
}

function spawnPlusOne(btn) {
    const popup = document.createElement('span');
    popup.className = 'like-popup';
    popup.textContent = '+1';

    const parent = btn.parentElement;
    parent.appendChild(popup);

    popup.offsetHeight; // Force reflow for animation
    popup.classList.add('show');

    setTimeout(() => popup.remove(), 500);
}
