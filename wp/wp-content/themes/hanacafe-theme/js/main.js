/**
 * HanaCAFE nappa69 Main JavaScript
 */
document.addEventListener('DOMContentLoaded', () => {
	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -50px 0px'
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				// visibleクラスを付与してCSSアニメーションをトリガー
				entry.target.classList.add('visible');
			}
		});
	}, observerOptions);

	// 全ての .reveal 要素を監視
	document.querySelectorAll('.reveal').forEach(el => {
		observer.observe(el);
	});
});