import asyncio
import random
from fastapi import FastAPI, UploadFile, File
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.post("/vision/analyze-waste")
async def analyze(file: UploadFile = File(...)):
    await asyncio.sleep(1.2)
    foods = ["米飯", "雞肉", "蔬菜", "牛肉", "魚", "麵條"]
    selected = random.choice(foods)
    weight = round(random.uniform(0.1, 1.5), 2)
    confidence = round(random.uniform(0.85, 0.99), 2)

    return {
        "items": [{"food_category": selected, "estimated_weight": weight, "confidence": confidence}],
        "total_estimated_weight": weight,
        "suggestion": f"建議明日「{selected}」備料量減少 {int(weight * 25)}%",
        "recommended_preparation": f"明日建議 {selected} 備料量減少 {round(weight * 0.25, 2)} kg"
    }
