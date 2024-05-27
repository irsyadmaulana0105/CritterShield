import numpy as np
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler

def denclue(X, k, max_iter=100):
    """
    DENCLUE clustering algorithm

    Parameters:
    X (numpy array): Data points
    k (int): Number of clusters
    max_iter (int): Maximum number of iterations

    Returns:
    labels (numpy array): Cluster labels for each data point
    """
    # Inisialisasi
    n_samples, n_features = X.shape
    labels = np.zeros(n_samples, dtype=int)
    centers = np.random.rand(k, n_features)

    # Iterasi
    for _ in range(max_iter):
        # Pencarian mode
        modes = np.zeros((k, n_features))
        for i in range(k):
            distances = np.linalg.norm(X - centers[i], axis=1)
            modes[i] = X[np.argmin(distances)]

        # Pembentukan cluster
        for i in range(k):
            cluster = np.zeros(n_samples, dtype=bool)
            for j in range(n_samples):
                if np.linalg.norm(X[j] - modes[i]) < np.linalg.norm(X[j] - modes[labels[j]]):
                    cluster[j] = True
            labels[cluster] = i

        # Penggabungan cluster
        for i in range(k):
            cluster = np.zeros(n_samples, dtype=bool)
            for j in range(n_samples):
                if np.linalg.norm(X[j] - modes[i]) < np.linalg.norm(X[j] - modes[labels[j]]):
                    cluster[j] = True
            labels[cluster] = i

    return labels

# Contoh data
np.random.seed(0)
X = np.random.rand(100, 2)

# Inisialisasi
k = 3

# Jalankan DENCLUE
labels = denclue(X, k)

# Visualisasi hasil
import matplotlib.pyplot as plt
plt.scatter(X[:, 0], X[:, 1], c=labels)
plt.show()